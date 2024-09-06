<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'pr_number',
        'patient_id',
        'doctor_id',
        'comments'
    ];

    public function patient (){
        return $this->belongsTo(User::class,'patient_id');
    }

    public function doctor (){
       return $this->belongsTo(User::class,'doctor_id');
    }

}
