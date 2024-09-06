<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTeeth extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',
        'patient_id',
        'doctor_id',
        'tooth_number',
        'procedure_performed',
        'status'
    ];

    public function toothIssues()
    {
        return $this->hasMany(ToothIssue::class,'p_teeth_id');
    }

    public function examInvestigation()
    {
        return $this->belongsTo(ExamInvestigation::class,'examination_id');
    }



}
