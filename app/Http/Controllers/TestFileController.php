<?php

namespace App\Http\Controllers;

use App\Models\PatientTeeth;
use App\Models\TeethProcedure;
use App\Models\TestFile;
use App\Models\User;
use App\Models\File;
use Illuminate\Http\Request;

class TestFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testFiles=TestFile::paginate(10);
        return view('test-file.index', compact('testFiles'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors = User::role('Doctor')->get();
        $patients = User::role('Patient')->get();
        return view('test-file.edit' ,compact('patients','doctors'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validation($request);
        $data = $request->only(['pr_number','patient_id','doctor_id','comments']);
        $testFile=TestFile::create($data);
        $testFile['pr_number'] = "Pr" ."-". date('y') ."-". date('m') . "-" .$testFile->id;
        $testFile->save();
        return redirect()->route('test-files.edit', $testFile->refresh()->id)->with('success', 'Procedure Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeethProcedure  $teethProcedure
     * @return \Illuminate\Http\Response
     */
    public function show(TestFile $testFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestFile  $testFile
     * @return \Illuminate\Http\Response
     */
    public function edit(TestFile $testFile)
    {
        $teeth_issues = PatientTeeth::where('patient_id', $testFile->patient_id)->with('toothIssues')->get();
        // dd($teeth_issues);
        $doctors = User::role('Doctor')->get();
        $patients = User::role('Patient')->get();

        return view('test-file.edit', compact('testFile', 'patients', 'doctors', 'teeth_issues'));
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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestFile  $testFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestFile $testFile)
    {
        $this->validation($request);
        $data = $request->only(['pr_number','patient_id','doctor_id','comments']);
        $testFile->update($data);
        return redirect()->route('test-files.index')->with('success', 'Procedure Updated.');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeethProcedure  $teethProcedure
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestFile $testFile)
    {
        $testFile->delete();
        return redirect()->route('test-files.index')->with('success', 'Procedure Deleted.');
    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'patient_id' => ['required', 'integer'],
            'doctor_id' => ['required', 'integer'],
            'tooth_number' => ['nullable', 'string', 'max:100']
        ]);
    }
}
