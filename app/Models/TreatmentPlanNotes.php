<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentPlanNotes extends Model
{
    use HasFactory;

    protected $fillable = ['patient_treatment_plan_id','datetime','username'];    

    public function patientTreatment(){
        return $this->belongsTo(PatientTreatmentPlan::class,'patient_treatment_plan_id');
    }
}
