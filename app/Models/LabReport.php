<?php

namespace App\Models;

use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Model;

class LabReport extends Model
{
    protected $fillable = [
        'company_id',
        'date',
        'patient_id',
        'doctor_id',
        'lab_report_template_id',
        'report',
        'photo',
        'created_by',
        'updated_by'
    ];

    public function labReportTemplate()
    {
        return $this->belongsTo(LabReportTemplate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
