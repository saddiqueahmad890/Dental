<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\UserLogs;
use App\Traits\Loggable;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;


class HospitalDepartment extends Model
{
    use SoftDeletes, Loggable;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'specialization',
        'status'
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function doctorDetails()
    {
        return $this->hasMany(DoctorDetail::class);
    }


}
