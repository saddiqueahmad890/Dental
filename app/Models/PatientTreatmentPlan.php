<?php

namespace App\Models;

use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTreatmentPlan extends Model
{
    use HasFactory,Loggable;

    protected $fillable = [
        'treatment_plan_number',
        'patient_id',
        'examination_id',
        'doctor_id',
        'comments',
        'status',
        'created_by',
        'updated_by'
    ];

    public function treatmentPlan(){
        return $this->hasMany(TreatmentPlanNotes::class,'patient_treatment_plan_id','id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patienttreatmentplanprocedures()
    {
        return $this->hasMany(PatientTreatmentPlanProcedure::class,'patient_treatment_plan_id');
    }

    public function examinvestigation()
    {
        return $this->belongsTo(ExamInvestigation::class, 'examination_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
