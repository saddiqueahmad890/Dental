<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLogs;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Auth;



class Insurance extends Model
{
    use Loggable;
    protected $fillable = [
        'company_id',
        'name',
        'service_tax',
        'discount',
        'description',
        'insurance_no',
        'insurance_code',
        'disease_charge',
        'hospital_rate',
        'insurance_rate',
        'total',
        'status',
    ];
    public function patient(){
        return $this->belongsTo(PatientDetail::class,'insurance_provider');
    }

}
