<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLogs;
use App\services\UserLogServices;
use App\Traits\Loggable;

class DdDrugHistory extends Model
{
    use HasFactory,Loggable;
    protected $table="dd_drug_histories";

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    public function patientDrugHistory(){
        return $this->hasMany(PatientDrugHistory::class,'dd_drug_history_id');
    }

}
