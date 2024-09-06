<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
 
class InvoiceItem extends Model
{
    use Loggable;
    protected $fillable = [
        'company_id',
        'invoice_id',
        'patient_treatment_plan_procedure_id',
        'title',
        'account_name',
        'description',
        'account_type',
        'quantity',
        'price'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function patienttreatmentplanprocedures()
    {
        return $this->belongsTo(PatientTreatmentPlanProcedure::class,'patient_treatment_plan_procedure_id');
    }

}
