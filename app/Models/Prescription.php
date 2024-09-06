<?php

namespace App\Models;


//use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLogs;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Auth;


class Prescription extends Model
{
    use Loggable;

    protected $fillable = [
        'user_id','examination_id', 'note', 'prescription_date', 'doctor_id', 'prs_number', 'created_by','updated_by'
    ];

    // user = patient
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function medicines()
    {
        return $this->hasMany(DdMedicine::class);
    }

    public function diagnoses()
    {
        return $this->hasMany(DdDiagnosis::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function doctor()
    {
        return $this->belongsTo(User::class,'doctor_id');
    }
    public function examinvestigations()
    {
        return $this->belongsTo(ExamInvestigation::class, 'examination_id');
    }

    public function patientmedicineitem()
    {
        return $this->hasMany(PatientMedicineItem::class,'prescription_id');
    }

    public function patientdiagnosisitem()
    {
        return $this->hasMany(PatientDiagnosisItem::class);
    }
    public function examinvestigation()
    {
        return $this->hasMany(ExamInvestigation::class, 'patient_id');
    }



}

