<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeethProcedure extends Model
{
    use HasFactory;
    protected $fillable = [
        'pr_number',
        'patient_id',
        'doctor_id',
        'comments',
        'patient_appointment_id'
    ];

    public function patient (){
        return $this->belongsTo(User::class,'patient_id');
    }

    public function doctor (){
       return $this->belongsTo(User::class,'doctor_id');
    }

    public function PatientAppointment (){
        return $this->belongsTo(PatientAppointment::class,'patient_appointment_id');
     }

    public function prescription(){
        return $this->belongsTo(Prescription::class,'user_id');
     }

}
