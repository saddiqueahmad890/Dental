<?php

namespace App\Models;
use App\Models\UserLogs;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;
class DoctorDetail extends Model
{
    use  Loggable;
    protected $fillable = [
        'user_id',
        'specialist',
        'designation',
        'doctor_biography',
        'commission',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCompanyIdAttribute()
    {
        return $this->user->company_id;
    }
    public function Invoice(){
        return $this->hasMany(Invoice::class);
    }
    public function newreport()
    {
        return $this->hasMany(NewReport::class);
    }
}
