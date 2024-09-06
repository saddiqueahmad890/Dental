<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSocialHistory extends Model
{
    use HasFactory,Loggable;

    protected $fillable = [
        'patient_id',
        'dd_social_history_id',
        'doctor_id',
        'comments',
        'created_by',
        'updated_by',
    ];

    public function examInvestigation(){
        return $this->hasMany(ExamInvestigation::class,'patient_id');
    }

    // Define relationship with DdMedicalHistory
    public function ddsocialhistory()
    {
        return $this->belongsTo(DdSocialHistory::class, 'dd_social_history_id');
    }



    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function ddDrug(){
        return $this->belongsTo(DdDrugHistory::class,'patient_id');
    }

    



}
