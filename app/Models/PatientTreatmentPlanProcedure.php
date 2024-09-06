<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTreatmentPlanProcedure extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_treatment_plan_id',
        'tooth_number',
        'all_teeth',
        'dd_procedure_id',
        'ready_to_start',
        'is_procedure_started',
        'is_procedure_finished'
    ];

    public function patienttreatmentplan(){
        return $this->belongsTo(PatientTreatmentPlan::class,'patient_treatment_plan_id');
    }
    public function procedure()
    {
        return $this->belongsTo(DdProcedure::class, 'dd_procedure_id');
    }
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'patient_treatment_plan_procedure_id');
    }
}
