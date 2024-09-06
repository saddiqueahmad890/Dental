<?php

namespace App\Models;
use App\services\UserLogServices;

use App\Http\Controllers\DdBloodGroupController;
use App\Traits\Loggable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App
 * @category model
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes,Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'address',
        'photo',
        'company_id',
        'locale',
        'date_of_birth',
        'gender',
        'blood_group',
        'status',
        'area',
        'city',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Has many relation with complains
     *
     * @return mixed
     */

    public function examInvestigation(){
        return $this->hasMany(ExamInvestigation::class,'patient_id','id');
    }
     
    public function companies()
    {
        return $this->morphToMany(Company::class, 'user', 'user_companies', 'user_id', 'company_id');
    }
      public function doctorexamInvestigation()
    {
        return $this->hasMany(ExamInvestigation::class,'doctor_id');
    }

    public function patientexamInvestigation()
    {
        return $this->hasMany(ExamInvestigation::class, 'patient_id');
    }
    public function newreport()
    {
        return $this->hasMany(NewReport::class);
    }



    public function doctorSchedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
    public function consultancyFees()
    {
        return $this->hasMany(ConsultanceyFee::class);
    }


    public function patientAppointments()
    {
        return $this->hasMany(PatientAppointment::class);
    }

    public function doctorAppointments()
    {
        return $this->hasMany(PatientAppointment::class, 'doctor_id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo)
            return asset($this->photo);
        else
            return asset('assets/images/placeholder.jpg');
    }

    public function patientCaseStudy()
    {
        return $this->hasOne(PatientCaseStudy::class);
    }

    public function labReports()
    {
        return $this->hasMany(LabReport::class, 'patient_id');
    }

    public function patientDetails()
    {
        return $this->hasOne(PatientDetail::class);
    }
    public function ddbloodgroup()
    {
        return $this->belongsTo(DdBloodGroup::class, 'blood_group');
    }
    public function lab()
    {
        return $this->hasMany(Lab::class);
    }
    public function patientDrugHistories()
    {
        return $this->hasMany(PatientDrugHistory::class, 'patient_id');
    }
    public function patientDentalHistories()
    {
        return $this->hasMany(PatientDentalHistory::class, 'patient_id');
    }
    public function patientMedicalHistories()
    {
        return $this->hasMany(PatientMedicalHistory::class, 'patient_id');
    }
    public function patientSocialHistories()
    {
        return $this->hasMany(PatientSocialHistory::class, 'patient_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
