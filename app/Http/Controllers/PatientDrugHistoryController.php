<?php

namespace App\Http\Controllers;

use App\Models\PatientDrugHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLogs;
use App\Traits\Loggable;

use App\Models\DdDrugHistory;
use Illuminate\Support\Facades\DB;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;


class PatientDrugHistoryController extends Controller
{
    use loggable;

    function __construct()
    {
        $this->middleware('permission:patient-drug-histories-read|patient-drug-histories-create|patient-drug-histories-update|patient-drug-histories-delete', ['only' => ['index','show']]);
        $this->middleware('permission:patient-drug-histories-create', ['only' => ['create','store']]);
        $this->middleware('permission:patient-drug-histories-update', ['only' => ['edit','update']]);
        $this->middleware('permission:patient-drug-histories-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->has('export') && $request->export) {
            return $this->doExport($request);
        }

        $patients = $this->filter($request)->orderBy('id', 'desc')->paginate(10);

        return view('patient-drug-history.index', compact('patients'));
    }


    private function filter(Request $request)
    {
        $query = User::role('Patient')
        ->where('status', '1')
            ->whereHas('patientDrugHistories') // Ensure patients have at least one drug history
            ->with('patientDrugHistories.dddrughistory', 'patientDrugHistories.doctor');

        if ($request->name) {
            $query->where('name', 'like', $request->name . '%');
        }

        if ($request->mrn_number) {
            $query->whereHas('patientDetails', function ($subquery) use ($request) {
                $subquery->where('mrn_number', 'like', $request->mrn_number . '%');
            });
        }
        return $query;
    }
    private function doExport(Request $request)
    {

        $patients = PatientDrugHistory::all();



        $data = $patients->map(function ($patient) {
            return [
                'id' => $patient->id,
                'MRN Number' => $patient->patient->patientDetails->mrn_number ?? 'N/A',
                'Patient Name' => $patient->patient->name ?? 'N/A',
                'Doctor Name' => $patient->doctor->name  ?? 'N/A',
                'Comments' => $patient->comments,
                'Created By' => $patient->created_by,
                'Updated By' => $patient->updated_by,
                'Created At' => $patient->created_at,
                'Updated At' => $patient->updated_at,
            ];
        })->toArray();
        $headers = ['MRN Number', 'Patient Name', 'Doctor Name', 'Comments', 'Created By', 'Updated By', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'PatientDrugHistories.xlsx');
    }




    public function create()
    {
        $doctor = User::role('Doctor')->where('status', '1')->orderBy('id', 'desc')->get();
        $patients = User::role('Patient')
        ->where('status', '1')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('patient_drug_histories')
                    ->whereRaw('patient_drug_histories.patient_id = users.id');
            })
            ->with('patientDetails')->orderBy('id', 'desc') // Load the related patientDetail
            ->get();
        $ddDrugHistory = DdDrugHistory::select('id', 'title')->where('status', '1')->get();

        return view('patient-drug-history.create', compact('doctor', 'patients', 'ddDrugHistory'));
    }
    public function createFromPatientDetails($userid)
    {
        // Fetch the selected patient ID
        $selectedPatientId = $userid;

        // Fetch doctors and other necessary data
        $doctor = User::role('Doctor')->where('status', '1')->get();
        $patients = User::role('Patient')
        ->where('status', '1')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('patient_drug_histories')
                    ->whereRaw('patient_drug_histories.patient_id = users.id');
            })
            ->with('patientDetails')
            ->get();
        $ddDrugHistory = DdDrugHistory::select('id', 'title')->where('status', '1')->get();

        // Pass data to view
        return view('patient-drug-history.create', compact('doctor', 'patients', 'ddDrugHistory', 'selectedPatientId'));
    }





    public function store(Request $request)
    {

        $this->validation($request);
        $patientId = $request->input('patient');
        $doctorId = $request->input('doctor');

        $patientDrugHistory = $request->input('drug_histories');

        $lastInsertedId = null;

        foreach ($patientDrugHistory as $id => $data) {
            if (isset($data['checked'])) {
                $record = [
                    'patient_id' => $patientId,
                    'doctor_id' => $doctorId,
                    'dd_drug_history_id' => $id,
                    'comments' => $data['comments'] ?? null,
                    'created_by' => auth()->id(),
                ];

                $createdRecord = PatientDrugHistory::create($record);
                $lastInsertedId = $createdRecord->id;
            }
        }

        if ($lastInsertedId) {
            return redirect()->route('patient-drug-histories.edit', $lastInsertedId)->with('success', 'Patient stored successfully');
        }

        return redirect()->route('patient-drug-histories.index')->with('warning', 'No valid drug history data to store');
    }


    public function show(PatientDrugHistory $patientDrugHistory)
    {


        $patientDrugHistories = PatientDrugHistory::where('patient_id', $patientDrugHistory->patient_id)->get();
        $patient = User::role('Patient')->findOrFail($patientDrugHistory->patient_id);
        $doctors = User::role('Doctor')->where('status', '1')->get();
        $ddDrugHistories = DdDrugHistory::select('id', 'title')->where('status', '1')->get();


        return view('patient-drug-history.show', compact('patientDrugHistories', 'patient', 'doctors', 'ddDrugHistories'));
    }





    public function edit(PatientDrugHistory $patientDrugHistory)
    {
        if (auth()->user()->hasRole('Doctor')) {
            if($patientDrugHistory->doctor_id != auth()->id()){
                return redirect()->route('patient-drug-histories.index')->with('error', trans('You Cannot Modify Other Doctors Created Drug Histories'));
            }
        }

        $patientDrugHistories = PatientDrugHistory::where('patient_id', $patientDrugHistory->patient_id)->get();
        $patient = User::role('Patient')->findOrFail($patientDrugHistory->patient_id);
        $doctors = User::role('Doctor')->where('status', '1')->get();
        $ddDrugHistories = DdDrugHistory::select('id', 'title')->where('status', '1')->get();

        $logs = UserLogs::where('table_name', 'patient_drug_histories')->orderBy('id', 'desc')
        ->with('user')
        ->paginate(10);


        return view('patient-drug-history.edit', compact('patientDrugHistories', 'patient', 'doctors', 'ddDrugHistories','logs'));
    }


    public function update(Request $request, $id)
    {
        $this->validation($request);
        $patientId = $request->input('patient');
        $doctorId = $request->input('doctor');
        $patientDrugHistory = $request->input('drug_histories');

        foreach ($patientDrugHistory as $drugHistoryId => $data) {
            $record = [
                // 'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'dd_drug_history_id' => $drugHistoryId,
                'comments' => $data['comments'],
                'updated_by' => auth()->id(),
            ];

            if (isset($data['checked'])) {

                PatientDrugHistory::updateOrCreate(
                    [
                        'patient_id' => $patientId,
                        'dd_drug_history_id' => $drugHistoryId,
                    ],
                    $record
                );
            } else {
                // If the record exists but is unchecked, delete it
                PatientDrugHistory::where('patient_id', $patientId)
                    ->where('dd_drug_history_id', $drugHistoryId)
                    ->delete();
            }
        }

        return redirect()->route('patient-drug-histories.index')->with('success', 'Patient drug history updated successfully');
    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'patient' => 'required|exists:users,id',
            'doctor' => 'required|exists:users,id',
            'comments' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);
    }
}
