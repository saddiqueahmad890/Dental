<?php

namespace App\Http\Controllers;

use App\Models\ExamInvestigation;
use App\Models\HospitalDepartment;
use App\Models\Invoice;
use App\Models\LabReport;
use App\Models\PatientAppointment;
use App\Models\PatientCaseStudy;
use App\Models\PatientTreatmentPlan;
use App\Models\Payment;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 * @category Controller
 */
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @access public
     * @return mixed
     */
    public function index()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            return $this->adminDashboard();
        } elseif(auth()->user()->hasRole('Admin')) {
            return $this->adminDashboard();
        } elseif(auth()->user()->hasRole('Doctor')) {
            $doctorId = auth()->user()->id;
            $patientAppointment = PatientAppointment::with('user')->where('doctor_id', $doctorId)->where('company_id', session('company_id'))->get();
            return view('dashboards.common-dashboard', compact('patientAppointment'));
        } elseif(auth()->user()->hasRole('Patient')) {
            $patientId = auth()->user()->id;
            $appointments = PatientAppointment::with('user')->where('user_id', $patientId)->where('company_id', session('company_id'))->get();
            return view('dashboards.common-dashboard', compact('appointments'));
        } elseif(auth()->user()->hasRole('Receptionist')) {
            $receptionistAppointments = PatientAppointment::with('user')->where('company_id', session('company_id'))->get();
            return view('dashboards.common-dashboard', compact('receptionistAppointments'));
        } else {
            return view('dashboards.common-dashboard');
        }
    }

    /**
     * shows admin dashboard
     *
     * @return \Illuminate\Http\Response
     */
    private function adminDashboard()
    {
        $dashboardCounts = $this->dashboardCounts();
        $monthlyDebitCredit = $this->monthlyDebitCredit();
        $currentYearDebitCredit = $this->currentYearDebitCredit();
        $overallDebitCredit = $this->overallDebitCredit();

        return view('dashboardview', compact('dashboardCounts', 'monthlyDebitCredit', 'currentYearDebitCredit', 'overallDebitCredit'));
    }

    /**
     * shows admin char data
     *
     * @return \Illuminate\Http\Response
     */
    public function getChartData()
    {
        return response()->json([
            'monthlyDebitCredit' => $this->monthlyDebitCredit(),
            'currentYearDebitCredit' => $this->currentYearDebitCredit(),
            'overallDebitCredit' => $this->overallDebitCredit()
        ], 200);
    }

    /**
     * sums debit/credit monthly for bar chart
     *
     * @return array
     */
    private function monthlyDebitCredit()
    {
        return cache()->remember('monthlyDebitCredit', 600, function () {
            $credits = []; $debits = []; $labels = [];
            $results = DB::select('SELECT DISTINCT YEAR(invoice_date) AS "year", MONTH(invoice_date) AS "month" FROM invoices ORDER BY year DESC LIMIT 12');
            foreach ($results as $result) {
                $labels[] = '"'.date('F', mktime(0, 0, 0, $result->month, 10)).' '.$result->year.'"';
                $credits[] = '"'.Payment::whereYear('payment_date', $result->year)->whereMonth('payment_date', $result->month)->sum('amount').'"';
                $debits[] = '"'.Invoice::whereYear('invoice_date', $result->year)->whereMonth('invoice_date', $result->month)->sum('grand_total').'"';
            }

            return [
                'credits' => $credits,
                'debits' => $debits,
                'labels' => $labels
            ];
        });
    }

    /**
     * sums debit/credit of current year for pie chart
     *
     * @return array
     */
    private function currentYearDebitCredit()
    {
        return cache()->remember('currentYearDebitCredit', 600, function () {
            $credits = 0; $debits = 0;

            $credits = Payment::whereYear('payment_date', date('Y'))->sum('amount');
            $debits = Invoice::whereYear('invoice_date', date('Y'))->sum('grand_total');

            return [
                'credits' => $credits,
                'debits' => $debits
            ];
        });
    }

    /**
     * sums debit/credit of overall for pie chart
     *
     * @return array
     */
    private function overallDebitCredit()
    {
        return cache()->remember('overallDebitCredit', 600, function () {
            $credits = 0; $debits = 0;

            $credits = Payment::sum('amount');
            $debits = Invoice::sum('grand_total');

            return [
                'credits' => $credits,
                'debits' => $debits
            ];
        });
    }

    private function dashboardCounts()
    {
        return cache()->remember('dashboardCounts', 600, function () {
            return [
                'departments' => HospitalDepartment::count(),
                'exam_investigation' => ExamInvestigation::count(),
                'treatment_plans' => PatientTreatmentPlan::count(),
                'doctors' => User::role('Doctor')->count(),
                'active_doctors' => User::role('Doctor')->where('status', '1')->count(),
                'nonactive_doctors' => User::role('Doctor')->where('status', '0')->count(),
                'patients' => User::role('Patient')->count(),
                'active_patients' => User::role('Patient')->where('status', '1')->count(),
                'nonactive_patients' => User::role('Patient')->where('status', '0')->count(),
                'appointments' => PatientAppointment::count(),
                'cancel' => PatientAppointment::where('appointment_status_id', 4)->count(), // Count appointments with status 4
                'processed' => PatientAppointment::where('appointment_status_id', 3)->count(), // Count appointments with status 4
                'case_studies' => PatientCaseStudy::count(),
                'prescriptions' => Prescription::count(),
                'invoices' => Invoice::count(),
                'payments' => Payment::count(),
                'total' => Invoice::sum('total'),     // Total sum of 'total' column in invoices table
                'labReports' => LabReport::count(),        
                'paid' => Invoice::sum('paid'),       // Total sum of 'paid' column in invoices table
                'totalAmount' => Payment::sum('amount') // Total sum of 'amount' column in payments table
            ];
        });


    }
}
