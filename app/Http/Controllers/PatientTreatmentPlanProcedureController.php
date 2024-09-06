<?php

namespace App\Http\Controllers;

use App\Models\PatientTreatmentPlanProcedure;
use Illuminate\Http\Request;
use App\Models\InvoiceItem;

class PatientTreatmentPlanProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['patient_treatment_plan_id','tooth_number','all_teeth','dd_procedure_id','ready_to_start','is_procedure_started','is_procedure_finished']);
        $attributes = [
            'patient_treatment_plan_id' => $request->treatment_plan_id,
            'tooth_number' => $request->tooth_number,
            'dd_procedure_id' => $request->procedure,
        ];

        $existingRecord = PatientTreatmentPlanProcedure::where($attributes)->first();

        if ($existingRecord) {
            if (InvoiceItem::where('patient_treatment_plan_procedure_id', $existingRecord->id)->exists()) {
                return response()->json([
                    'message' => 'Record cannot be updated as it is associated with an invoice item.'
                ], 403);
            }
        }

        $planProcedure = PatientTreatmentPlanProcedure::updateOrCreate($attributes, $data);
        return response()->json(['message' => 'Record saved successfully.','planProcedure' => $planProcedure], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientTreatmentPlanProcedure  $patientTreatmentPlanProcedure
     * @return \Illuminate\Http\Response
     */
    public function show(PatientTreatmentPlanProcedure $patientTreatmentPlanProcedure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientTreatmentPlanProcedure  $patientTreatmentPlanProcedure
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientTreatmentPlanProcedure $patientTreatmentPlanProcedure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientTreatmentPlanProcedure  $patientTreatmentPlanProcedure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatientTreatmentPlanProcedure $patientTreatmentPlanProcedure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientTreatmentPlanProcedure  $patientTreatmentPlanProcedure
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $procedure = PatientTreatmentPlanProcedure::find($id);

        if (!$procedure) {
            return response()->json(['message' => 'Record not found!'], 404);
        }

        // Check if the procedure has associated invoice items
        if (InvoiceItem::where('patient_treatment_plan_procedure_id', $id)->exists()) {
            return response()->json(['message' => 'Record cannot be deleted as it is associated with an invoice item.'], 403);
        }

        $procedure->delete();
        return response()->json(['message' => 'Record deleted successfully.'], 200);
    }


}
