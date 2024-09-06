<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use App\Models\UserLogs;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;

class PatientCaseStudy extends Model
{
    protected $fillable = [
        'user_id',
        'food_allergy',
        'heart_disease',
        'high_blood_pressure',
        'diabetic',
        'surgery',
        'accident',
        'others',
        'family_medical_history',
        'current_medication',
        'pregnancy',
        'breastfeeding',
        'health_insurance',
        'file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); //patient user
    }



}
