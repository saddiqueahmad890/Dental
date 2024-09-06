<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Models\UserLogs;
use App\Traits\Loggable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedicalHistory extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'patient_id',
        'dd_medical_history_id',
        'doctor_id',
        'comments',
        'created_by',
        'updated_by',
    ];


    public function examInvestigations()
    {
        return $this->hasMany(ExamInvestigation::class, 'patient_id');
    }


    public function ddMedicalHistory()
    {
        return $this->belongsTo(DdMedicalHistory::class, 'dd_medical_history_id');
    }



    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    


}
