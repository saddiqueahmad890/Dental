<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamInvestigation extends Model
{
    use HasFactory;
    protected $fillable = [
        'examination_number',
        'patient_id',
        'doctor_id',
        'comments',
        'patient_appointment_id',
        'history_chief_complaint_id',
        'created_by',
        'updated_by'
    ];


    public function patientDrugHistory(){
        return $this->belongsTo(PatientDrugHistory::class,'patient_id','patient_id');
    }

    public function patientMedicalHistory()
    {
        return $this->belongsTo(PatientMedicalHistory::class, 'patient_id','patient_id');
    }

    public function patientdentalHistory(){
        return $this->belongsTo(PatientDentalHistory::class,'patient_id','patient_id');
    }

    // public function dentalHistory(){
    //     return $this->belongsTo(DdDentalHistory::class,'patient_id');
    // }

    public function patientsocial(){
        return $this->belongsTo(PatientSocialHistory::class,'patient_id','patient_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'patient_id');
    }

    public function hardTissue(){
        return $this->belongsTo(HardTissue::class,'soft_tissue_id');
    }

    public function softTissue(){
        return $this->belongsTo(SoftTissues::class,'soft_tissue_id');
    }

    public function intraOral(){
        return $this->belongsTo(IntraOral::class,'intra_oral_id');
    }

    public function extraOral(){
        return $this->belongsTo(ExtraOral::class,'extra_oral');
    }

    public function histroyofcomplaints(){
        return $this->belongsTo(HistoryOfChiefComplaints::class,'history_chief_complaint_id');
    }

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

    public function patienttreatmentplan()
    {
        return $this->hasMany(PatientTreatmentPlan::class,'examination_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

}
