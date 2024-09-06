<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\UserLogs;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Auth;



class Invoice extends Model
{
    use Loggable;
    protected $fillable = [
        'company_id',
        'user_id',
        'insurance_id',
        'patient_treatment_plan_id',
        'invoice_date',
        'total',
        'vat_percentage',
        'total_vat',
        'discount_percentage',
        'total_discount',
        'commission_percentage',
        'doctor_id',
        'total_commission',
        'grand_total',
        'paid',
        'due',
        'created_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class,'doctor_id');
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function patienttreatmentplan()
    {
        return $this->belongsTo(PatientTreatmentPlan::class,'patient_treatment_plan_id');
    }

    public function invoicePayments()
    {
        return $this->hasMany(InvoicePayment::class);
    }
    public function newreport()
    {
        return $this->hasMany(NewReport::class);
    }
    public function doctor()
    {
        return $this->belongsTo(User::class,'doctor_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

}
