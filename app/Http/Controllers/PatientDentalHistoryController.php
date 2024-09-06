<?php

namespace App\Http\Controllers;

use App\Models\PatientDentalHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLogs;
use App\Models\DdDentalHistory;
use Illuminate\Support\Facades\DB;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;

class PatientDentalHistoryController extends Controller
{
    use Loggable;

    function __construct()
    {
        $this->middleware('permission:patient-dental-histories-read|patient-dental-histories-create|patient-dental-histories-update|patient-dental-histories-delete', ['only' => ['index','show']]);
        $this->middleware('permission:patient-dental-histories-create', ['only' => ['create','store']]);
        $this->middleware('permission:patient-dental-histories-update', ['only' => ['edit','update']]);
        $this->middleware('permission:patient-dental-histories-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        if ($request->has('export') && $request->export) {
            return $this->doExport($request);
        }

        $patients = $this->filter($request)->orderBy('id', 'desc')->paginate(10);

        return view('patient-dental-histories.index', compact('patients'));
    }


    private function filter(Request $request)
    {
        $query = User::role('Patient')
            ->where('status', '1')
            ->whereHas('patientDentalHistories') // Ensure patients have at least one dental history
            ->with('patientDentalHistories.dddentalhistory', 'patientDentalHistories.doctor');

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

        $patients = PatientDentalHistory::all();



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

        return Excel::download(new GenericExport($data, $headers), 'PatientDentalHistories.xlsx');
    }


    public function create()
    {

        $doctor = User::role('Doctor')->where('status', '1')->orderBy('id', 'desc')->get();
        $patients = User::role('Patient')
            ->where('status', '1')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('patient_dental_histories')
                    ->whereRaw('patient_dental_histories.patient_id = users.id');
            })
            ->with('patientDetails')->orderBy('id', 'desc')
            ->get();
        $ddDentalHistory = DdDentalHistory::select('id', 'title')->where('status', '1')->get();

        return view('patient-dental-histories.create', compact('doctor', 'patients', 'ddDentalHistory'));
    }
    public function createFromPatientDetails($userid)
    {
        $selectedPatientId = $userid;

        $doctor = User::role('Doctor')->where('status', '1')->get();
        $patients = User::role('Patient')
            ->where('status', '1')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('patient_dental_histories')
                    ->whereRaw('patient_dental_histories.patient_id = users.id');
            })
            ->with('patientDetails')
            ->get();
        $ddDentalHistory = DdDentalHistory::select('id', 'title')->where('status', '1')->get();

        return view('patient-dental-histories.create', compact('doctor', 'patients', 'ddDentalHistory', 'selectedPatientId'));
    }


    public function store(Request $request)
    {
        $this->validation($request);
        $patientId = $request->input('patient');
        $doctorId = $request->input('doctor');

        $patientDentalHistory = $request->input('dental_histories');

        $lastInsertedId = null;

        foreach ($patientDentalHistory as $id => $data) {
            if (isset($data['checked'])) {
                $record = [
                    'patient_id' => $patientId,
                    'doctor_id' => $doctorId,
                    'dd_dental_history_id' => $id,
                    'comments' => $data['comments'] ?? null,
                    'created_by' => auth()->id(),
                ];

                $createdRecord = PatientDentalHistory::create($record);
                $lastInsertedId = $createdRecord->id;
            }
        }

        if ($lastInsertedId) {
            return redirect()->route('patient-dental-histories.edit', $lastInsertedId)->with('success', 'Patient stored successfully');
        }

        return redirect()->route('patient-dental-histories.index')->with('warning', 'No valid dental history data to store');
    }


    public function show(PatientDentalHistory $patientDentalHistory)
    {


        $patientDentalHistories = PatientDentalHistory::where('patient_id', $patientDentalHistory->patient_id)->get();
        $patient = User::role('Patient')->findOrFail($patientDentalHistory->patient_id);
        $doctors = User::role('Doctor')->where('status', '1')->get();
        $ddDentalHistories = DdDentalHistory::select('id', 'title')->where('status', '1')->get();


        return view('patient-dental-histories.show', compact('patientDentalHistories', 'patient', 'doctors', 'ddDentalHistories'));
    }





    public function edit(PatientDentalHistory $patientDentalHistory)
    {
        if (auth()->user()->hasRole('Doctor')) {
            if($patientDentalHistory->doctor_id != auth()->id()){
                return redirect()->route('patient-dental-histories.index')->with('error', trans('You Cannot Modify Other Doctors created Dental History'));
            }
        }
        $patientDentalHistories = PatientDentalHistory::where('patient_id', $patientDentalHistory->patient_id)->get();
        $patient = User::role('Patient')->findOrFail($patientDentalHistory->patient_id);
        $doctors = User::role('Doctor')->where('status', '1')->get();
        $ddDentalHistories = DdDentalHistory::select('id', 'title')->where('status', '1')->get();

        $logs = UserLogs::where('table_name', 'patient_dental_histories')->orderBy('id', 'desc')->with('user')->paginate(10);
        return view('patient-dental-histories.edit', compact('patientDentalHistories', 'patient', 'doctors', 'ddDentalHistories', 'logs'));
    }


    public function update(Request $request, $id)
    {
        // ;
        $this->validation($request);
        $patientId = $request->input('patient');
        $doctorId = $request->input('doctor');
        $patientDentalHistory = $request->input('dental_histories');

        foreach ($patientDentalHistory as $dentalHistoryId => $data) {
            $record = [
                // 'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'dd_dental_history_id' => $dentalHistoryId,
                'comments' => $data['comments'],
                'updated_by' => auth()->id(),
            ];

            if (isset($data['checked'])) {

                PatientDentalHistory::updateOrCreate(
                    [
                        'patient_id' => $patientId,
                        'dd_dental_history_id' => $dentalHistoryId,
                    ],
                    $record
                );
            } else {
                // If the record exists but is unchecked, delete it
                PatientDentalHistory::where('patient_id', $patientId)
                    ->where('dd_dental_history_id', $dentalHistoryId)
                    ->delete();
            }
        }



        //at end in compact add logs

        return redirect()->route('patient-dental-histories.index')->with('success', 'Patient dental history updated successfully');
    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'patient' => 'required|exists:users,id',
            // 'dd_dental_history_id' => 'required|integer',
            'doctor' => 'required|exists:users,id',
            'comments' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);
    }
}
