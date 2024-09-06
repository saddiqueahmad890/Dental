<?php

namespace App\Http\Controllers;

use App\Models\PatientTeeth;
use App\Models\TeethProcedure;
use App\Models\User;
use App\Models\File;
use App\Models\PatientAppointment;
use Illuminate\Http\Request;

class TeethProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public function index(Request $request)
{

    $teethProcedures = $this->filter($request)->orderBy('id', 'desc')->paginate(10);

    $doctors = User::role('Doctor')->whereHas('doctorteethProcedures')->get();
    $patients = User::role('Patient')->whereHas('patientteethProcedures')->get();

    return view('teeth-procedure.index', compact('teethProcedures', 'patients', 'doctors'));
}

private function filter(Request $request)
{
    $query = TeethProcedure::query();

    if ($request->has('pr_number') && !empty($request->input('pr_number'))) {
        $query->where('pr_number', 'like', $request->input('pr_number') . '%');
    }
    if ($request->has('mrn_number') && !empty($request->input('mrn_number'))) {
        $query->whereHas('patient.patientDetails', function ($q) use ($request) {
            $q->where('mrn_number', 'like', $request->input('mrn_number') . '%');
        });
    }
    if ($request->has('patient_id') && !empty($request->input('patient_id'))) {
        $query->where('patient_id', $request->input('patient_id'));
    }
    if ($request->has('doctor_id') && !empty($request->input('doctor_id'))) {
        $query->where('doctor_id', $request->input('doctor_id'));
    }

    return $query;
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors = User::role('Doctor')->get();
        $patientAppointments  = PatientAppointment::get();
        $patients = User::role('Patient')->get();
        return view('teeth-procedure.edit' ,compact('patients','doctors','patientAppointments'));
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
        $data = $request->only(['pr_number','patient_id','patient_appointment_id','doctor_id','comments']);
        $teethProcedure=TeethProcedure::create($data);
        $teethProcedure['pr_number'] = "Pr" ."-". date('y') ."-". date('m') . "-" .$teethProcedure->id;
        $teethProcedure->save();
        return redirect()->route('teeth-procedures.edit', $teethProcedure->refresh()->id)->with('success', 'Procedure Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeethProcedure  $teethProcedure
     * @return \Illuminate\Http\Response
     */
    public function show(TeethProcedure $teethProcedure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeethProcedure  $teethProcedure
     * @return \Illuminate\Http\Response
     */
    public function edit(TeethProcedure $teethProcedure)
    {
        $teeth_issues = PatientTeeth::where('patient_id', $teethProcedure->patient_id)->with('toothIssues')->get();
        $patientAppointments  = PatientAppointment::get();
        $doctors = User::role('Doctor')->get();
        $patients = User::role('Patient')->get();

        return view('teeth-procedure.edit', compact('teethProcedure', 'patients', 'doctors', 'teeth_issues','patientAppointments'));
    }


    public function getToothIssues($procedureId,$patientId, $toothNumber)
    {
    $patientTeeth = PatientTeeth::where('teeth_procedures_id', $procedureId)->where('patient_id', $patientId)
        ->where('tooth_number', $toothNumber)
        ->first();

    if ($patientTeeth) {
        $toothIssues = $patientTeeth->toothIssues()->get();
        return response()->json($toothIssues);
    } else {
        return response()->json([]);
    }
    }
    public function getTeethIssues($procedure_id)
    {
    $teethIssues = PatientTeeth::where('teeth_procedures_id', $procedure_id)->pluck('tooth_number');
    return response()->json($teethIssues);
    }

    public function getTeethFiles(Request $request) {
        $procedureId = $request->query('procedure_id');
        $toothNumber = $request->query('tooth_number');
        $response = [
            'files' => []
        ];

        // Get all teeth files for the record, procedure, and tooth number from the database
        $files = File::where('record_id', $procedureId)
                     ->where('child_record_id', $toothNumber)
                     ->where('record_type', 'teeth_files')
                     ->get();

        // Get all unique user IDs from the files
        $userIds = $files->pluck('created_by')->unique();

        // Fetch all users that are referenced in the files
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        // Prepare the response data
        foreach ($files as $file) {
            $fileData = [
                'file_name' => $file->file_name,
                'uploaded_by' => isset($users[$file->created_by]) ? $users[$file->created_by]->name : 'Unknown',
                'uploaded_at' => $file->created_at->format('Y-m-d H:i:s')
            ];

            $response['files'][] = $fileData;
        }

        return response()->json($response);
    }

    public function getTeethFile(Request $request)
{
    $procedureId = $request->input('procedure_id');
    $toothNumber = $request->input('tooth_number');
    $files = []; // Fetch the files based on $procedureId and $toothNumber

    // Example response structure
    $response = [
        'files' => [
            [
                'file_name' => 'teeth_files_1720010989.jpg',
                'uploaded_by' => 'Super Admin',
                'uploaded_at' => '2024-07-03 12:49:49'
            ]
        ]
    ];

    return response()->json($response);
    }

    public function fetchAppointments(Request $request)
    {
        $patientId = $request->input('patient_id');
        $appointments = PatientAppointment::where('user_id', $patientId)->get(['id','appointment_number']);
        return response()->json(['appointments' => $appointments]);
    }

    public function fetchDoctors(Request $request)
    {
        $patient_appointment_id = $request->input('patient_appointment_id');
        $doctor_id = PatientAppointment::where('id', $patient_appointment_id)->pluck('doctor_id')->first();

        $doctors = User::where('id', $doctor_id)->get(['id','name']);
        return response()->json(['doctors' => $doctors]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeethProcedure  $teethProcedure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeethProcedure $teethProcedure)
    {
        $this->validation($request);
        $data = $request->only(['pr_number','patient_id','doctor_id','comments']);
        $teethProcedure->update($data);
        return redirect()->route('teeth-procedures.index')->with('success', 'Procedure Updated.');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeethProcedure  $teethProcedure
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeethProcedure $teethProcedure)
    {
        $teethProcedure->delete();
        return redirect()->route('teeth-procedures.index')->with('success', 'Procedure Deleted.');
    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'patient_id' => ['required', 'integer'],
            'doctor_id' => ['required', 'integer'],
            'comments' => ['nullable', 'string', 'max:100']
        ]);
    }
}
