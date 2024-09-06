<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDentalHistory extends Model
{
    use HasFactory,Loggable;

    protected $fillable = [
        'patient_id',
        'dd_dental_history_id',
        'doctor_id',
        'comments',
        'created_by',
        'updated_by',
    ];

    public function examInvestigation(){
        return $this->hasMany(ExamInvestigation::class,'patient_id');
    }

    // Define relationship with DdMedicalHistory
    public function dddentalhistory()
    {
        return $this->belongsTo(DdDentalHistory::class, 'dd_dental_history_id');
    }

    public function user()
    {
        return $this->belongsTo(PatientDetail::class);
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
