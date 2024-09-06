<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\services\UserLogServices;

class PatientDiagnosisItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'diagnosis_id',
        'instruction',
    ];
    public function prescription()
    {
        return $this->belongsTo(Prescription::class,'prescription_id');
    }

    public function dddiagnosis()
    {
        return $this->belongsTo(DdDiagnosis::class,'diagnosis_id');
    }

}
