<?php

namespace App\Http\Controllers;

use App\Models\PatientMedicalHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\Loggable;
use App\Models\UserLogs;
use App\Models\DdMedicalHistory;
use Illuminate\Support\Facades\DB;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;

class PatientMedicalHistoryController extends Controller
{
    use Loggable;


    function __construct()
    {
        $this->middleware('permission:patient-medical-histories-read|patient-medical-histories-create|patient-medical-histories-update|patient-medical-histories-delete', ['only' => ['index','show']]);
        $this->middleware('permission:patient-medical-histories-create', ['only' => ['create','store']]);
        $this->middleware('permission:patient-medical-histories-update', ['only' => ['edit','update']]);
        $this->middleware('permission:patient-medical-histories-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->has('export') && $request->export) {
            return $this->doExport($request);
        }

        $patients = $this->filter($request)->orderBy('id', 'desc')->paginate(10);

        return view('patient-medical-histories.index', compact('patients'));
    }


    private function filter(Request $request)
    {
        $query = User::role('Patient')
        ->where('status', '1')
            ->whereHas('patientMedicalHistories') // Ensure patients have at least one medical history
            ->with('patientMedicalHistories.ddmedicalhistory', 'patientMedicalHistories.doctor');

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

        $patients = PatientMedicalHistory::all();



        $data = $patients->map(function ($patient) {
            return [
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

        return Excel::download(new GenericExport($data, $headers), 'PatientMedicalHistories.xlsx');
    }

    public function create()
    {
        $doctor = User::role('Doctor')->where('status', '1')->orderBy('id', 'desc')->get();
        $patients = User::role('Patient')
        ->where('status', '1')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('patient_medical_histories')
                    ->whereRaw('patient_medical_histories.patient_id = users.id');
            })
            ->with('patientDetails')->orderBy('id', 'desc')
            ->get();
        $ddMedicalHistory = DdMedicalHistory::select('id', 'title')->where('status', '1')->get();

        return view('patient-medical-histories.create', compact('doctor', 'patients', 'ddMedicalHistory'));
    }

    public function createFromPatientDetails($userid)
    {
        $selectedPatientId = $userid;

        $doctor = User::role('Doctor')->where('status', '1')->get();
        $patients = User::role('Patient')
        ->where('status', '1')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('patient_medical_histories')
                    ->whereRaw('patient_medical_histories.patient_id = users.id');
            })
            ->with('patientDetails')
            ->get();
        $ddMedicalHistory = DdMedicalHistory::select('id', 'title')->where('status', '1')->get();

        return view('patient-medical-histories.create', compact('doctor', 'patients', 'ddMedicalHistory', 'selectedPatientId'));
    }




    // public function store(Request $request)
    // {
    //     $this->validation($request);
    //     $patientId = $request->input('patient');
    //     $doctorId = $request->input('doctor');

    //     $patientMedicalHistory = $request->input('medical_histories');

    //     $recordsToInsert = [];

    //     foreach ($patientMedicalHistory as $id => $data) {
    //         if (isset($data['checked'])) {
    //             $record = [
    //                 'patient_id' => $patientId,
    //                 'doctor_id' => $doctorId,
    //                 'dd_medical_history_id' => $data['title_id'],
    //                 'created_by' => auth()->id(),
    //                 'comments' => $data['comments'] ?? null,
    //             ];

    //             $recordsToInsert[] = $record;
    //         }
    //     }

    //     // Insert all records
    //     $lastInsertedId = null;
    //     foreach ($recordsToInsert as $record) {
    //         $lastInsertedId = PatientMedicalHistory::create($record)->id;
    //     }

    //     return redirect()->route('patient-medical-histories.edit', $lastInsertedId)->with('success', 'Patient Medical History Saved Successfully');
    // }
    public function store(Request $request)
    {
        // Perform validation
        $this->validation($request);

        $patientId = $request->input('patient');
        $doctorId = $request->input('doctor');
        $patientMedicalHistory = $request->input('medical_histories');

        $recordsToInsert = [];
        $lastInsertedId = null;

        foreach ($patientMedicalHistory as $id => $data) {
            if (isset($data['checked'])) {
                $record = [
                    'patient_id' => $patientId,
                    'doctor_id' => $doctorId,
                    'dd_medical_history_id' => $data['title_id'],
                    'created_by' => auth()->id(),
                    'comments' => $data['comments'] ?? null,
                ];

                $createdRecord = PatientMedicalHistory::create($record);
                $lastInsertedId = $createdRecord->id;
            }
        }

        if ($lastInsertedId) {
            return redirect()->route('patient-medical-histories.edit', $lastInsertedId)
                             ->with('success', 'Patient Medical History Saved Successfully');
        }

        return redirect()->route('patient-medical-histories.index')
                         ->with('warning', 'No valid medical history data to store');
    }

    public function show(PatientMedicalHistory $patientMedicalHistory)
    {


        $patientMedicalHistories = PatientMedicalHistory::where('patient_id', $patientMedicalHistory->patient_id)->get();
        $patient = User::role('Patient')->findOrFail($patientMedicalHistory->patient_id);
        $doctors = User::role('Doctor')->where('status', '1')->get();
        $ddMedicalHistories = DdMedicalHistory::select('id', 'title')->where('status', '1')->get();


        return view('patient-medical-histories.show', compact('patientMedicalHistories', 'patient', 'doctors', 'ddMedicalHistories'));
    }




    public function edit(PatientMedicalHistory $patientMedicalHistory)
    {

        if (auth()->user()->hasRole('Doctor')) {
            if($patientMedicalHistory->doctor_id != auth()->id()){
                return redirect()->route('patient-medical-histories.index')->with('error', trans('You Cannot Modify Other Doctors created Medical Histories'));
            }
        }
        $patientMedicalHistories = PatientMedicalHistory::where('patient_id', $patientMedicalHistory->patient_id)->get();
        $patient = User::role('Patient')->findOrFail($patientMedicalHistory->patient_id);
        $doctors = User::role('Doctor')->where('status', '1')->orderBy('id', 'desc')->get();
        $ddMedicalHistories = DdMedicalHistory::select('id', 'title')->where('status', '1')->get();

        // start of log
        $logs = UserLogs::where('table_name', 'patient_medical_histories')->orderBy('id', 'desc')
            ->with('user')
            ->paginate(10);
        // end of log



        return view('patient-medical-histories.edit', compact('patientMedicalHistories', 'patient', 'doctors', 'ddMedicalHistories', 'logs'));
    }


    public function update(Request $request, $id)
    {

        $this->validation($request);
        $patientId = $request->input('patient');
        $doctorId = $request->input('doctor');
        $patientMedicalHistory = $request->input('medical_histories');

        foreach ($patientMedicalHistory as $medicalHistoryId => $data) {
            $record = [
                // 'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'dd_medical_history_id' => $medicalHistoryId,
                'comments' => $data['comments'],
                'updated_by' => auth()->id(),
            ];

            if (isset($data['checked'])) {

                PatientMedicalHistory::updateOrCreate(
                    [
                        'patient_id' => $patientId,
                        'dd_medical_history_id' => $medicalHistoryId,
                    ],
                    $record
                );
            } else {
                // If the record exists but is unchecked, delete it
                PatientMedicalHistory::where('patient_id', $patientId)
                    ->where('dd_medical_history_id', $medicalHistoryId)
                    ->delete();
            }
        }

        return redirect()->route('patient-medical-histories.index')->with('success', 'Patient medical history updated successfully');
    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'patient' => 'required|exists:users,id',
            // 'dd_medical_history_id' => 'required|integer',
            'doctor' => 'required|exists:users,id',
            'comments' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);
    }
}
