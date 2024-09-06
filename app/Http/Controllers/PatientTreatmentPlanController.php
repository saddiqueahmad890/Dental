<?php

namespace App\Http\Controllers;

use App\Models\ExamInvestigation;
use App\Models\PatientTeeth;
use App\Models\PatientTreatmentPlan;
use App\Models\TeethProcedure;
use App\Models\DdProcedureCategory;
use App\Models\Company;
use App\Models\PatientTreatmentPlanProcedure;
use App\Models\User;
use App\Models\DdProcedure;
use App\Models\InvoiceItem;
use App\Models\UserLogs;
use App\Models\TreatmentPlanNotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;


class PatientTreatmentPlanController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:patient-treatment-plans-read|patient-treatment-plans-create|patient-treatment-plans-update|patient-treatment-plans-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:patient-treatment-plans-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:patient-treatment-plans-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:patient-treatment-plans-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request, $doctorId = null)
    {
        if ($request->export) {
            return $this->doExport($request);
        }

        // Apply filtering based on the optional doctorId
        $patientTreatmentPlans = $this->filter($request, $doctorId)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Pass the data to the view
        return view('patient-treatment-plans.index', compact('patientTreatmentPlans'));
    }

    private function filter(Request $request)
    {
        $query = PatientTreatmentPlan::where('status', '1')
            ->with(['patient', 'doctor', 'examinvestigation']);

        if ($request->name) {
            $query->whereHas('patient', function ($subquery) use ($request) {
                $subquery->where('name', 'like', $request->name . '%');
            });
        }
        if ($request->mrn_number) {
            $query->whereHas('patient.patientDetails', function ($subquery) use ($request) {
                $subquery->where('mrn_number', 'like', $request->mrn_number . '%');
            });
        }
        if ($request->examination_number) {
            $query->whereHas('examinvestigation', function ($subquery) use ($request) {
                $subquery->where('examination_number', 'like', $request->examination_number . '%');
            });
        }

        return $query;
    }

    public function doExport(Request $request)
    {
        $patientTreatmentPlansQuery = $this->filter($request);
        $patientTreatmentPlans = $patientTreatmentPlansQuery->get();

        $data = $patientTreatmentPlans->map(function ($plan) {
            return [
                'ID' => $plan->id,
                'Treatment Plan Number' => $plan->treatment_plan_number,
                'Patient Name' => $plan->patient->name ?? 'N/A',
                'Doctor Name' => $plan->doctor->name ?? 'N/A',
                'Examination Number' => $plan->examinvestigation->examination_number ?? 'N/A',
                'Comments' => $plan->comments,
                'Status' => $plan->status,
                'Created At' => $plan->created_at,
                'Updated At' => $plan->updated_at,
            ];
        })->toArray();

        $headers = [
            'ID', 'Treatment Plan Number', 'Patient Name', 'Doctor Name',
            'Examination Number', 'Comments', 'Status', 'Created At', 'Updated At'
        ];

        return Excel::download(new GenericExport($data, $headers), 'PatientTreatmentPlans.xlsx');
    }


    public function create(Request $request)
    {
        if($request->examination_id){
            $examinationData=ExamInvestigation::where('id',$request->examination_id)->first();
            // dd($examinationData);
            return view('patient-treatment-plans.create', compact('examinationData'));
        }
        $patients = User::role('Patient')->whereHas('patientexamInvestigation')->orderBy('created_at','desc')->get();
        return view('patient-treatment-plans.create', compact('patients'));
    }

    public function fetchProcedure(Request $request)
    {
        $categoryId = $request->input('procedure_category');
        $ddprocedures = DdProcedure::where('dd_procedure_id', $categoryId)->get(['id', 'title']);
        return response()->json(['ddprocedures' => $ddprocedures]);
    }

    public function fetchTreatmentDetails(Request $request)
    {
        $treatmentPlanId = $request->query('treatment_plan_id');
        $treatmentPlan = DdProcedure::where('id', $treatmentPlanId)->first(['price', 'description']);
        return response()->json(['treatmentPlan' => $treatmentPlan]);
    }


    public function store(Request $request)
    {
        $this->validation($request);
        $data = $request->only(['patient_id', 'doctor_id', 'examination_id', 'comments']);
        $plan = PatientTreatmentPlan::create($data);
        $plan['treatment_plan_number'] = "TPL" . "-" . date('y') . "-" . date('m') . "-" . date('d') . "-" . $plan->id;
        $plan['created_by']=auth()->id();
        $plan->save();

        return redirect()->route('patient-treatment-plans.edit', $plan->id)->with('success', 'Treatment Plan created successfully.');
    }



    // public function show(Request $request, PatientTreatmentPlan $patientTreatmentPlan)
    // {
    //     $printType = $request->query('print', 'all');

    //     $teeth = PatientTeeth::with('toothIssues')->where('examination_id', $patientTreatmentPlan->examination_id)->get();

    //     if ($printType === 'ready') {
    //         $patientTreatmentPlanProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)
    //             ->whereIn('tooth_number', $teeth->pluck('tooth_number')->toArray())
    //             ->where('ready_to_start', 'yes')
    //             ->whereNotExists(function ($query) {
    //                 $query->select(DB::raw(1))
    //                     ->from('invoice_items')
    //                     ->whereRaw('invoice_items.patient_treatment_plan_procedure_id = patient_treatment_plan_procedures.id');
    //             })
    //             ->get();
    //         $allTeethProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)
    //             ->where('ready_to_start', 'yes')
    //             ->where('all_teeth', 'yes')
    //             ->whereNotExists(function ($query) {
    //                 $query->select(DB::raw(1))
    //                     ->from('invoice_items')
    //                     ->whereRaw('invoice_items.patient_treatment_plan_procedure_id = patient_treatment_plan_procedures.id');
    //             })
    //             ->get();

    //     } else {
    //         $patientTreatmentPlanProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)
    //             ->whereIn('tooth_number', $teeth->pluck('tooth_number')->toArray())
    //             ->get();
    //         $allTeethProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)->where('all_teeth','yes')->get();

    //     }


    //     $totalPrice = $patientTreatmentPlanProcedures->sum(function($procedure) {
    //         return $procedure->procedure->price;
    //     });

    //     $allteethPrice = $allTeethProcedures->sum(function($procedure) {
    //         return $procedure->procedure->price;
    //     });

    //     $totalPrice = $totalPrice + $allteethPrice;

    //     $company = Company::find(1);
    //     $company->setSettings();

    //     return view('patient-treatment-plans.show', compact('patientTreatmentPlan', 'company', 'patientTreatmentPlanProcedures', 'teeth','totalPrice','allTeethProcedures'));
    // }


    public function show(Request $request, PatientTreatmentPlan $patientTreatmentPlan)
{
    $printType = $request->query('print', 'all');

    $teeth = PatientTeeth::with('toothIssues')->where('examination_id', $patientTreatmentPlan->examination_id)->get();

    $groupedTeeth = $teeth->groupBy(function ($tooth) {
        return $tooth->toothIssues->pluck('tooth_issue')->first(); // Group by the first issue of each tooth
    });

    if ($printType === 'ready') {
        $patientTreatmentPlanProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)
            ->whereIn('tooth_number', $teeth->pluck('tooth_number')->toArray())
            ->where('ready_to_start', 'yes')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('invoice_items')
                    ->whereRaw('invoice_items.patient_treatment_plan_procedure_id = patient_treatment_plan_procedures.id');
            })
            ->get();
        $allTeethProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)
            ->where('ready_to_start', 'yes')
            ->where('all_teeth', 'yes')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('invoice_items')
                    ->whereRaw('invoice_items.patient_treatment_plan_procedure_id = patient_treatment_plan_procedures.id');
            })
            ->get();
    } else {
        $patientTreatmentPlanProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)
            ->whereIn('tooth_number', $teeth->pluck('tooth_number')->toArray())
            ->get();
        $allTeethProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)->where('all_teeth', 'yes')->get();
    }

    $totalPrice = $patientTreatmentPlanProcedures->sum(function($procedure) {
        return $procedure->procedure->price;
    });

    $allteethPrice = $allTeethProcedures->sum(function($procedure) {
        return $procedure->procedure->price;
    });

    $totalPrice = $totalPrice + $allteethPrice;

    $company = Company::find(1);
    $company->setSettings();

    return view('patient-treatment-plans.show', compact('patientTreatmentPlan', 'company', 'patientTreatmentPlanProcedures', 'teeth', 'groupedTeeth', 'totalPrice', 'allTeethProcedures'));
}



    public function edit(PatientTreatmentPlan $patientTreatmentPlan)
    {
        if (auth()->user()->hasRole('Doctor')) {
            if($patientTreatmentPlan->doctor_id != auth()->id()){
                return redirect()->route('patient-treatment-plans.index')->with('error', trans('You Cannot Modify Other Doctors Created Treatment Plans'));
            }
        }
        if (!$patientTreatmentPlan->patienttreatmentplanprocedures->isEmpty()) {
            $allProceduresInvoiced = $patientTreatmentPlan->patienttreatmentplanprocedures->every(function ($procedure) {
                return $procedure->invoiceItems()->exists();
            });

            if ($allProceduresInvoiced) {
                return redirect()->route('patient-treatment-plans.index')->with('error', trans('The treatment plan is already completed.'));
            }
        }

        $procedureCategories = DdProcedureCategory::get(['id', 'title']);
        //start of log code
        $logs = UserLogs::where('table_name', 'patient_social_histories')->orderBy('id', 'desc')
        ->with('user')
        ->paginate(10);
        // end changing for log
        //at end in compact add logs
        $patients = User::role('Patient')->where('status', '1')->get();
        $doctors = User::role('Doctor')->where('status', '1')->get();
        $teethProcedures = ExamInvestigation::all();
        $procedures = DdProcedure::all();
        $teeth = PatientTeeth::with('toothIssues')->where('examination_id', $patientTreatmentPlan->examination_id)->get();
        $patientTreatmentPlanProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)
            ->whereIn('tooth_number', $teeth->pluck('tooth_number')->toArray())
            ->get();
        $invoiceItems = InvoiceItem::whereIn('patient_treatment_plan_procedure_id', $patientTreatmentPlanProcedures->pluck('id'))->get();
        $nonInvoicedProceduresCount = $patientTreatmentPlan->patienttreatmentplanprocedures->filter(function ($procedure) {
            return !InvoiceItem::where('patient_treatment_plan_procedure_id', $procedure->id)->exists();
        })->count();


        $allTeethProcedures = PatientTreatmentPlanProcedure::where('patient_treatment_plan_id', $patientTreatmentPlan->id)->where('all_teeth','yes')->get();

        $hasPlanProcedures = $patientTreatmentPlanProcedures->isNotEmpty();
        $hasReadyToStartProcedures = $patientTreatmentPlanProcedures->contains('ready_to_start', 'yes');
        $hasFinishedProcedures = $patientTreatmentPlanProcedures->contains('is_procedure_finished', 'yes');

        $showGenerateInvoiceButton = $hasFinishedProcedures && $nonInvoicedProceduresCount > 0;

        $patientNotes = TreatmentPlanNotes::where('patient_treatment_plan_id',$patientTreatmentPlan->id)->get();


        return view('patient-treatment-plans.edit', compact('procedures','nonInvoicedProceduresCount' ,'patientTreatmentPlanProcedures', 'teeth', 'patientTreatmentPlan', 'logs', 'procedureCategories', 'patients', 'doctors', 'teethProcedures', 'invoiceItems','hasReadyToStartProcedures','hasPlanProcedures','showGenerateInvoiceButton','allTeethProcedures','patientNotes'));
    }

    public function treatmentNotes(Request $request){
        $notes = new TreatmentPlanNotes();
        $notes->patient_treatment_plan_id = $request->patient_treatment_plan_id;
        $notes->username = $request->username;
        $notes->save();
        return response()->json([
            'success' => true,
            'message' => 'Treatment Plan Notes created successfully.'
        ]);
    }

    public function showtreatmentNotes(){
        $notes = TreatmentPlanNotes::with('treatmentPlan')->get();
        return view('patient-treatment-plans.edit', compact('notes'));
    }

    public function updateShowPrice(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'show_price' => 'required|boolean',
        ]);

        $model = PatientTreatmentPlanProcedure::find($validated['id']);
        if ($model) {
            $model->show_price = $validated['show_price'];
            $model->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function fetchProcedures(Request $request)
    {
        $patientId = $request->input('patient_id');
        $examInvestigation = ExamInvestigation::where('patient_id', $patientId)->orderBy('created_at', 'desc')->get(['id', 'examination_number']);
        return response()->json(['procedures' => $examInvestigation]);
    }

    public function fetchTeeth(Request $request)
    {
        $examinationId = $request->input('examination_id');
        $examInvestigation = ExamInvestigation::with('doctor')->find($examinationId);
        $doctorDetails = $examInvestigation->doctor;
        $teeth = PatientTeeth::with('toothIssues')->where('examination_id', $examinationId)->get();
        return response()->json(['teeth' => $teeth, 'doctorDetails' => $doctorDetails]);
    }

    public function update(Request $request, PatientTreatmentPlan $patientTreatmentPlan)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'status' => 'required|in:1,0',
        ]);
        $patientTreatmentPlan['updated_by']=auth()->id();

        $patientTreatmentPlan->update($request->all());

        // Redirect to the edit page of the updated plan
        return redirect()->route('patient-treatment-plans.edit', $patientTreatmentPlan->id)->with('success', 'Treatment Plan updated successfully.');
    }


    public function destroy(PatientTreatmentPlan $patientTreatmentPlan)
    {

        if (auth()->user()->hasRole('Doctor')) {
            if($patientTreatmentPlan->doctor_id != auth()->id()){
                return redirect()->route('patient-treatment-plans.index')->with('error', trans('You Cannot Delete Other Doctors Created Treatment Plans'));
            }
        }


        if ($patientTreatmentPlan->patienttreatmentplanprocedures()->exists())
            return redirect()->route('patient-treatment-plans.index')->with('error', trans('Treatment Plan cannot be Deleted'));


        if ($patientTreatmentPlan->invoices()->exists())
        return redirect()->route('patient-treatment-plans.index')->with('error', trans('Treatment Cannot be deleted Because Invoice Already Exists'));

        $patientTreatmentPlan->delete();
        return redirect()->route('patient-treatment-plans.index')->with('success', 'Treatment Plan deleted successfully.');
    }

    private function validation(Request $request)
    {
        $request->validate([
            'patient_id' => ['required', 'integer', 'exists:users,id'],
            'doctor_id' => ['required', 'integer', 'exists:users,id'],
            'examination_id' => ['required', 'integer','exists:exam_investigations,id'],
            'comments' => ['nullable', 'string'],
        ]);
    }
}
