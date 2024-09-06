<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientTreatmentProcess;
use App\Models\User;
use App\Models\UserLogs;


class PatientTreatmentProcessController extends Controller
{
    public function index()
    {
         
        $patientTreatmentProcesses = PatientTreatmentProcess::orderby('id','Desc')->paginate(10);
        return view('patient_treatment_processes.index', compact('patientTreatmentProcesses' ));
    }


    public function create()
    {
        $doctor = User::role('Doctor')->where('status', '1')->get();


        return view('patient_treatment_processes.create', compact('doctor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_treatment_plan_id' => 'required',
            // Add validation rules for other fields
        ]);

        $process = PatientTreatmentProcess::create($request->all());

        // Redirect to the edit page for the newly created process
        return redirect()->route('patient-treatment-processes.edit', $process->id)->with('success', trans('Patient Treatment Process Added Successfully'));
    }


    public function show(PatientTreatmentProcess $patientTreatmentProcess)
    {
        return view('patient_treatment_processes.show', compact('patientTreatmentProcess'));
    }

    public function edit(PatientTreatmentProcess $patientTreatmentProcess)
    {
        $doctor = User::role('Doctor')->where('status', '1')->get();



        return view('patient_treatment_processes.edit', compact('patientTreatmentProcess','doctor'));
    }

    public function update(Request $request, PatientTreatmentProcess $patientTreatmentProcess)
    {
        $request->validate([
            'patient_treatment_plan_id' => 'required',
            // Add validation rules for other fields
        ]);

        $patientTreatmentProcess->update($request->all());
        return redirect()->route('patient-treatment-processes.edit', $patientTreatmentProcess->id)->with('success', trans('Patient Treatment Process Added Successfully'));
    }

    public function destroy(PatientTreatmentProcess $patientTreatmentProcess)
    {
        $patientTreatmentProcess->delete();
        return redirect()->route('patient-treatment-processes.index');
    }
}
