<?php

namespace App\Http\Controllers;

use App\Models\PatientTeeth;
use App\Models\User;
use App\Models\ToothIssue;
use Illuminate\Http\Request;

class PatientTeethController extends Controller
{

    public function index()
    {
        $patientTeeths=PatientTeeth::paginate(10);
        return view('patient-teeth.index', compact('patientTeeths'));
    }

    public function create()
    {
        return view('patient-teeth.create');
    }




    public function store(Request $request)
    {
        if ($request->has('teeth') && $request->has('issues')) {
            // Handle saving teeth issues
            $teeth = $request->input('teeth', []);
            $issues = $request->input('issues', []);
            $doctorId = $request->input('doctor_id');
            $patientId = $request->input('patient_id');
            $examinationId = $request->input('examination_id');

            $existingPatientTeeth = PatientTeeth::where('examination_id', $examinationId)->get();
            $existingTeethIds = $existingPatientTeeth->pluck('id')->toArray();

            ToothIssue::whereIn('p_teeth_id', $existingTeethIds)->delete();
            PatientTeeth::whereIn('id', $existingTeethIds)->delete();

            foreach ($teeth as $tooth) {
                $attributes = [
                    'examination_id' => $examinationId,
                    'patient_id' => $patientId,
                    'doctor_id' => $doctorId,
                    'tooth_number' => $tooth,
                ];
                $patientTeeth = PatientTeeth::Create($attributes);

                $toothIssues = [];
                foreach ($issues as $issue) {
                    $toothIssues[] = [
                        'p_teeth_id' => $patientTeeth->id,
                        'tooth_number' => $tooth,
                        'tooth_issue' => $issue['tooth_issue'],
                        'description' => $issue['description'],
                    ];
                }

                ToothIssue::insert($toothIssues);
            }

            return response()->json(['success' => true, 'message' => 'Teeth issues saved successfully (Bulk)']);
        } else {
            // Existing logic
            $this->validation($request);
            $data = $request->only(['examination_id', 'patient_id', 'doctor_id', 'tooth_number', 'procedure_performed', 'status']);
            $attributes = [
                'examination_id' => $request->examination_id,
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'tooth_number' => $request->tooth_number,
            ];
            $patientTeeth = PatientTeeth::updateOrCreate($attributes, $data);

            $toothIssues = [];
            $tooth_issue = $request->input('tooth_issue');
            $descriptions = $request->input('description');

            ToothIssue::where('tooth_number', $request->tooth_number)
                ->where('p_teeth_id', $patientTeeth->id)
                ->delete();

            foreach ($tooth_issue as $key => $issue) {
                if (!empty($issue)) {
                    $toothIssues[] = [
                        'p_teeth_id' => $patientTeeth->id,
                        'tooth_number' => $request->input('tooth_number'),
                        'tooth_issue' => $issue,
                        'description' => $descriptions[$key],
                    ];
                }
            }

            ToothIssue::insert($toothIssues);

            return response()->json([
                'message' => 'PatientTeeth record and related tooth issues saved successfully',
                'data' => ['tooth_number' => $patientTeeth->tooth_number]
            ]);
        }
    }



    public function show(PatientTeeth $patientTeeth)
    {
        return view('patient-teeth.show', compact('patientTeeth'));
    }

    public function edit(PatientTeeth $patientTeeth)
    {
        return view('patient-teeth.edit', compact('patientTeeth'));
    }

    public function update(Request $request, PatientTeeth $patientTeeth)
    {
        $this->validation($request);
        $data = $request->only(['patient_id','doctor_id','tooth_number','procedure_performed','status']);
        $patientTeeth->update($data);
        return redirect()->route('patient-teeths.index')->with('success', 'Teeth Issue Updated.');
    }



    public function destroy(PatientTeeth $patientTeeth)
    {
        $patientTeeth->delete();
        return redirect()->route('patient-teeths.index')->with('success', trans('Teeth Issue Deleted.'));    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'examination_id' => ['nullable', 'integer'],
            'patient_id' => ['nullable', 'integer'],
            'doctor_id' => ['nullable', 'integer'],
            'tooth_number' => ['required', 'string', 'max:10'],
            'procedure_performed' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:20']
        ]);
    }

}
