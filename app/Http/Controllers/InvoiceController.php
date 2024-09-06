<?php

namespace App\Http\Controllers;

use App\Models\AccountHeader;
use App\Models\Company;
use App\Models\Insurance;
use App\Models\Invoice;
use App\Models\DoctorDetail;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\PatientTreatmentPlan;
use App\Models\PatientTreatmentPlanProcedure;
use App\Models\PatientTeeth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:invoice-read|invoice-create|invoice-update|invoice-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:invoice-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:invoice-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:invoice-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (auth()->user()->hasRole('Patient'))
            $patients = User::role('Patient')->where('id', auth()->id())->where('status', '1')->get(['id', 'name']);
        else
            $patients = User::role('Patient')->where('status', '1')->get(['id', 'name']);

        $doctors = User::role('Doctor')->get();
        $invoices = $this->filter($request)->orderby('id', 'desc')->paginate(10);


        $totalGrandTotal = $invoices->sum('grand_total');
        $totalPaid = $invoices->sum('paid');
        $totalDue = $invoices->sum('due');
        return view('invoices.index', compact('invoices', 'patients', 'doctors', 'totalGrandTotal', 'totalPaid', 'totalDue'));
    }

    /**
     * Filter function
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    private function filter(Request $request)
    {
        $query = Invoice::where('company_id', session('company_id'));

        if (auth()->user()->hasRole('Patient')) {
            $query->where('user_id', auth()->id());
        } elseif ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->invoice_number) {
            $query->where('invoice_number', 'like', '%' . $request->invoice_number . '%');
        }

        if ($request->invoice_date) {
            $query->where('invoice_date', $request->invoice_date);
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('invoice_date', [$request->start_date, $request->end_date]);
        } elseif ($request->start_date) {
            $query->where('invoice_date', '>=', $request->start_date);
        }

        // Join the patient_treatment_plans table to filter by doctor
        if ($request->doctor_id) {
            $query->whereHas('patienttreatmentplan', function ($q) use ($request) {
                $q->where('doctor_id', $request->doctor_id);
            });
        }

        return $query;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->treatment_plan_id) {
            $patientTreatmentPlan = PatientTreatmentPlan::find($request->treatment_plan_id);
            $doctors = User::role('Doctor')->where('id', $patientTreatmentPlan->doctor_id)->get(['id', 'name']);
            $patients = User::where('id', $patientTreatmentPlan->patient_id)->get(['id', 'name']);

            $percentage = DoctorDetail::where('user_id', $patientTreatmentPlan->doctor_id)->pluck('commission')->first();
            $teeth = PatientTeeth::with('toothIssues')->where('examination_id', $patientTreatmentPlan->examination_id)->get();
            $patientTreatmentPlanProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)
            ->where(function($query) use ($teeth) {
                $query->whereIn('tooth_number', $teeth->pluck('tooth_number')->toArray())
                      ->orWhereNull('tooth_number');
            })
            ->where('ready_to_start', 'yes')
            ->where('is_procedure_started', 'yes')
            ->where('is_procedure_finished', 'yes')
            ->whereDoesntHave('invoiceItems') // Ensure procedures not already invoiced
            ->get();
            $insurances = Insurance::where('status', '1')->get();
            $accountHeader = AccountHeader::where('type', 'Debit')->where('status', '1')->first();
            return view('invoices.create', compact('patients', 'patientTreatmentPlan', 'insurances', 'accountHeader', 'patientTreatmentPlanProcedures', 'teeth', 'doctors', 'percentage'));
        }
        $accountHeader = AccountHeader::where('type', 'Debit')->where('status', '1')->first();
        $insurances = Insurance::where('status', '1')->get();
        $patients = User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->orderBy('created_at', 'desc')->get(['id', 'name']);
        $doctors = User::role('Doctor')->orderBy('created_at', 'desc')->get(['id', 'name']);
        return view('invoices.create', compact('accountHeader', 'insurances', 'patients', 'doctors'));
    }

    public function fetchCommission(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $doctor = DoctorDetail::where('user_id', $doctorId)->first();


        if ($doctor) {
            return response()->json([
                'success' => true,
                // 'doctor'=>$doctor,
                'commission_percentage' => $doctor->commission, // Adjust according to your model
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validation($request);
        $invoice = null;
        DB::transaction(function () use ($request, &$invoice) {
            $invoice = Invoice::create([
                'company_id' => session('company_id'),
                'user_id' => $request->user_id,
                'insurance_id' => $request->insurance_id,
                'doctor_id' => $request->doctor_id,
                'commission_percentage' => $request->commission_percentage,
                'patient_treatment_plan_id' => $request->patient_treatment_plan_id,
                'invoice_date' => Carbon::parse($request->invoice_date),
                'created_by' => auth()->id()
            ]);
            $invoice['invoice_number'] = getDocNumber($invoice->id, 'INV');
            $invoice->save();

            $this->storeInvoice($request, $invoice);
        });

        return redirect()->route('invoices.edit', $invoice)->with('success', trans('Invoice Added Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        if (auth()->user()->hasRole('Patient') && auth()->id() != $invoice->user_id)
            return redirect()->route('dashboard');

        $company = Company::find($invoice->company_id);
        $company->setSettings();





        return view('invoices.show', compact('company', 'invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $doctors = User::role('Doctor')->where('id', $invoice->doctor_id)->get(['id', 'name']);
        $patients = User::role('Patient')->where('id', $invoice->user_id)->get(['id', 'name']);
        $accountHeader = AccountHeader::where('type', 'Debit')->where('status', '1')->first();
        $insurances = Insurance::where('status', '1')->get();
        $invoicePayments = InvoicePayment::where('invoice_id', $invoice->id)->get();
        $totalPaidAmount = $invoicePayments->sum('paid_amount');
        $grandTotal = $invoice->grand_total;
        // dd($invoice->user->patientDetails->insurance_verified);
        return view('invoices.edit', compact('accountHeader', 'insurances', 'invoice', 'patients', 'invoicePayments', 'totalPaidAmount', 'grandTotal', 'doctors'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {

        $this->validation($request);
        $invoice->invoiceItems()->delete();
        $invoice->updated_by = auth()->id();

        $this->storeInvoice($request, $invoice);
        $invoice->save();
        return redirect()->route('invoices.index')->with('success', trans('Invoice Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->invoiceItems()->exists())
            return redirect()->route('invoices.index')->with('error', trans('Invoice Cannot be deleted'));

        $invoice->invoiceItems()->delete();
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', trans('Invoice Removed Successfully'));
    }

    /**
     * Stores invoce data
     *
     * @param Request $request
     * @param Invoice $invoice
     * @return void
     */
    private function storeInvoice(Request $request, Invoice $invoice)
    {
        DB::transaction(function () use ($request, $invoice) {
            $invoiceItems = [];
            $total = 0;
            foreach ($request->patient_treatment_plan_procedure_id as $key => $value) {
                $itemTotal = round(($request->quantity[$key] * $request->price[$key]), 2);
                $invoiceItems[] = [
                    'company_id' => session('company_id'),
                    'invoice_id' => $invoice->id,
                    'patient_treatment_plan_procedure_id' => empty($request->patient_treatment_plan_procedure_id[$key]) ? null : $request->patient_treatment_plan_procedure_id[$key],
                    'title' => $request->title[$key],
                    'account_name' => $request->account_name[$key],
                    'description' => $request->description[$key],
                    'account_type' => 'Debit',
                    'quantity' => round($request->quantity[$key], 2),
                    'price' => round($request->price[$key], 2),
                    'total' => round($itemTotal, 2),
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $total += $itemTotal;
            }
            InvoiceItem::insert($invoiceItems);

            $grandTotal = round($total, 2);
            $totalDiscount = round($request->total_discount, 2);
            if ($request->discount_percentage > 0)
                $totalDiscount = ($request->discount_percentage / 100) * $total;
            $grandTotal -= round($totalDiscount, 2);


            $totalVat = round($request->total_vat, 2);
            if ($request->vat_percentage > 0)
                $totalVat = ($request->vat_percentage / 100) * $grandTotal;
            $grandTotal += round($totalVat, 2);
            // dd(round($request->vat_percentage, 2));


            // Commission calculation
            // $grandTotal = round($total, 2);
            $totalCommission = round($request->total_commission, 2);

            // Calculate the commission based on the percentage
            if ($request->commission_percentage > 0) {
                $doctorCommission = ($request->commission_percentage / 100) * $grandTotal;
            } else {
                $doctorCommission = $totalCommission;
            }

            // Subtract the calculated commission from the grand total
            // $grandTotal -= $doctorCommission;

            // Round the final commission amount
            $doctorCommission = round($doctorCommission, 2);

            // End of commission calculation


            $invoice->update([
                'insurance_id' => $request->insurance_id,
                'invoice_date' => now(),
                'vat_percentage' => $request->vat_percentage,
                'total_vat' => $totalVat,
                'total' => $total,
                'discount_percentage' => $request->discount_percentage,
                'total_commission' => $doctorCommission,
                'total_discount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'paid' => $request->paid,
                'due' => $grandTotal - $request->paid
            ]);
        });
    }

    /**
     * Validation function
     *
     * @param Request $request
     * @return void
     */
    private function validation(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'insurance_id' => ['nullable', 'integer', 'exists:insurances,id'],
            'invoice_date' => ['required', 'date'],
            'vat_percentage' => ['required', 'numeric'],
            'total_vat' => ['required', 'numeric'],
            'discount_percentage' => ['required', 'numeric'],
            'total_discount' => ['required', 'numeric'],
            'paid' => ['required', 'numeric'],
            'title' => ['required', 'array'],
            'description' => ['required', 'array'],
            'quantity' => ['required', 'array'],
            'price' => ['required', 'array'],
            'total' => ['required', 'numeric']
        ]);
    }
}
