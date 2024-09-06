<?php

namespace App\Models;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdMedicalHistory extends Model
{
    use HasFactory,Loggable;
    protected $table="dd_medical_histories";

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'created_by',
        'updated_by	',
    ];

    public function patientMedicalHistories()
    {
        return $this->hasMany(PatientMedicalHistory::class, 'dd_medical_history_id');
    }

}
