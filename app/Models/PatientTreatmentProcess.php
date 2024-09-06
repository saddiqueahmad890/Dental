<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTreatmentProcess extends Model
{
    use HasFactory;

    protected $table = 'patient_treatment_process';

    protected $fillable = [
        'patient_treatment_plan_id',
        'comments',
        'process_started_at',
        'process_completed_at',
        'doctor_id',
        'status',
        'created_by',
        'updated_by',
    ];

    public function treatmentPlan()
    {
        return $this->belongsTo(PatientTreatmentPlan::class, 'patient_treatment_plan_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

//     public function creator()
//     {
//         return $this->belongsTo(User::class, 'created_by');
//     }

//     public function updater()
//     {
//         return $this->belongsTo(User::class, 'updated_by');
//     }


}
