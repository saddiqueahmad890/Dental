<?php

namespace App\Http\Controllers;

use App\Models\PatientSocialHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLogs;
use App\Traits\Loggable;
use App\Models\DdSocialHistory;
use Illuminate\Support\Facades\DB;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;
class PatientSocialHistoryController extends Controller
{
    use loggable;

    function __construct()
    {
        $this->middleware('permission:patient-social-histories-read|patient-social-histories-create|patient-social-histories-update|patient-social-histories-delete', ['only' => ['index','show']]);
        $this->middleware('permission:patient-social-histories-create', ['only' => ['create','store']]);
        $this->middleware('permission:patient-social-histories-update', ['only' => ['edit','update']]);
        $this->middleware('permission:patient-social-histories-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->has('export') && $request->export) {
            return $this->doExport($request);
        }

        $patients = $this->filter($request)->orderBy('id', 'desc')->paginate(10);

        return view('patient-social-histories.index', compact('patients'));
    }


    private function filter(Request $request)
    {
        $query = User::role('Patient')
        ->where('status', '1')
            ->whereHas('patientSocialHistories') // Ensure patients have at least one social history
            ->with('patientSocialHistories.ddsocialhistory', 'patientSocialHistories.doctor');

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

        $patients = PatientSocialHistory::all();



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

        return Excel::download(new GenericExport($data, $headers), 'PatientSocialHistories.xlsx');
    }

    public function create()
    {

        $doctor = User::role('Doctor')->where('status', '1')->orderBy('id', 'desc')->get();
        $patients = User::role('Patient')
            ->where('status', '1')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('patient_social_histories')
                    ->whereRaw('patient_social_histories.patient_id = users.id');
            })
            ->with('patientDetails')->orderBy('id', 'desc')
            ->get();
        $ddSocialHistory = DdSocialHistory::select('id', 'title')->where('status', '1')->get();

        return view('patient-social-histories.create', compact('doctor', 'patients', 'ddSocialHistory'));
    }
    public function createFromPatientDetails($userid)
    {
        $selectedPatientId = $userid;

        $doctor = User::role('Doctor')->where('status', '1')->get();
        $patients = User::role('Patient')
        ->where('status', '1')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('patient_social_histories')
                    ->whereRaw('patient_social_histories.patient_id = users.id');
            })
            ->with('patientDetails')
            ->get();
        $ddSocialHistory = DdSocialHistory::select('id', 'title')->where('status', '1')->get();

        return view('patient-social-histories.create', compact('doctor', 'patients', 'ddSocialHistory', 'selectedPatientId'));
    }



    public function store(Request $request)
    {
        $this->validation($request);
        $patientId = $request->input('patient');
        $doctorId = $request->input('doctor');

        $patientSocialHistory = $request->input('social_histories');

        $lastInsertedId = null;

        foreach ($patientSocialHistory as $id => $data) {
            if (isset($data['checked'])) {
                $record = [
                    'patient_id' => $patientId,
                    'doctor_id' => $doctorId,
                    'dd_social_history_id' => $id,
                    'comments' => $data['comments'] ?? null,
                    'created_by' => auth()->id(),
                ];

                $createdRecord = PatientSocialHistory::create($record);
                $lastInsertedId = $createdRecord->id;
            }
        }

        if ($lastInsertedId) {
            return redirect()->route('patient-social-histories.edit', $lastInsertedId)->with('success', 'Patient stored successfully');
        }

        return redirect()->route('patient-social-histories.index')->with('warning', 'No valid social history data to store');
    }


    public function show(PatientSocialHistory $patientSocialHistory)
    {


        $patientSocialHistories = PatientSocialHistory::where('patient_id', $patientSocialHistory->patient_id)->get();
        $patient = User::role('Patient')->findOrFail($patientSocialHistory->patient_id);
        $doctors = User::role('Doctor')->where('status', '1')->get();
        $ddSocialHistories = DdSocialHistory::select('id', 'title')->where('status', '1')->get();


        return view('patient-social-histories.show', compact('patientSocialHistories', 'patient', 'doctors', 'ddSocialHistories'));
    }





    public function edit(PatientSocialHistory $patientSocialHistory)
    {

        if (auth()->user()->hasRole('Doctor')) {
            if($patientSocialHistory->doctor_id != auth()->id()){
                return redirect()->route('patient-social-histories.index')->with('error', trans('You Cannot Modify Other Doctors Created Social Histories'));
            }
        }
        $patientSocialHistories = PatientSocialHistory::where('patient_id', $patientSocialHistory->patient_id)->get();
        $patient = User::role('Patient')->findOrFail($patientSocialHistory->patient_id);
        $doctors = User::role('Doctor')->where('status', '1')->get();
        $ddSocialHistories = DdSocialHistory::select('id', 'title')->where('status', '1')->get();


        $logs = UserLogs::where('table_name', 'patient_social_histories')->orderBy('id', 'desc')
        ->with('user')
        ->paginate(10);



        return view('patient-social-histories.edit', compact('patientSocialHistories', 'patient','doctors', 'ddSocialHistories','logs'));
    }


    public function update(Request $request, $id)
    {

        $this->validation($request);
        $patientId = $request->input('patient');
        $doctorId = $request->input('doctor');
        $patientSocialHistory = $request->input('social_histories');

        foreach ($patientSocialHistory as $socialHistoryId => $data) {
            $record = [
                // 'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'dd_social_history_id' => $socialHistoryId,
                'comments' => $data['comments'],
                'updated_by' => auth()->id(),
            ];

            if (isset($data['checked'])) {

                PatientSocialHistory::updateOrCreate(
                    [
                        'patient_id' => $patientId,
                        'dd_social_history_id' => $socialHistoryId,
                    ],
                    $record
                );
            } else {
                // If the record exists but is unchecked, delete it
                PatientSocialHistory::where('patient_id', $patientId)
                    ->where('dd_social_history_id', $socialHistoryId)
                    ->delete();
            }
        }

        return redirect()->route('patient-social-histories.index')->with('success', 'Patient social history updated successfully');
    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'patient' => 'required|exists:users,id',
            // 'dd_social_history_id' => 'required|integer',
            'doctor' => 'required|exists:users,id',
            'comments' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);
    }
}
