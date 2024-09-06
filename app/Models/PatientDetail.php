<?php

namespace App\Models;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    use Loggable;
    protected $fillable = [
        "user_id",
        "mrn_number",
        "marital_status",
        "insurance_provider_id",
        'insurance_verified',
        'insurance_verified_by',
        'insurance_verified_at',
        'cnic',
        'credit_balance',
        'area',
        'enquirysource',
        'city',
        "cnic_file",
        "insurance_card",
        "other_files",
        'other_details',
        'created_by',
        'updated_by'

    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function enquirysource()
    {
        return $this->belongsTo(EnquirySource::class, 'enquirysource' );
    }
    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status');
    }
    public function insurance(){
        return $this->belongsTo(InsuranceProvider::class,'insurance_provider_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
