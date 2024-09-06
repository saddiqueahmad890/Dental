<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDrugHistory extends Model
{
    use HasFactory,Loggable;

    protected $fillable = [
        'patient_id',
        'dd_drug_history_id',
        'doctor_id',
        'comments',
        'created_by',
        'updated_by'
    ];

    public function examInvestigation(){
        return $this->hasMany(ExamInvestigation::class,'patient_id');
    }

    // Define relationship with Patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Define relationship with DdMedicalHistory
    public function dddrughistory()
    {
        return $this->belongsTo(DdDrugHistory::class,'dd_drug_history_id');
    }

}
