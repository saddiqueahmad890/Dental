<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdDiagnosis extends Model
{
    use HasFactory,Loggable;


    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by'
    ];
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }



}
