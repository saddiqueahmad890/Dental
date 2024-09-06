<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdMedicineType extends Model
{
    use HasFactory,Loggable;

    protected $fillable = [
        'name',
        'description',
        'status',
        'created_by',
        'updated_by'
    ];
    public function ddMedicine()
    {
        return $this->hasMany(DdMedicine::class, 'dd_medicine_type', 'id');
    }
    public function prescriptions()
    {
        return $this->belongsToMany(Prescription::class);
    }

    public function medicines()
    {
        return $this->hasMany(DdMedicine::class);
    }




}
