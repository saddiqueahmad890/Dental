<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\services\UserLogServices;


class PatientMedicineItem extends Model
{
    use HasFactory;
    protected $fillable = [
    'prescription_id',
    'medicine_id',
    'medicine_type_id',
    'instruction',
    'day'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class,'prescription_id');
    }

    public function ddmedicinetype()
    {
        return $this->belongsTo(DdMedicineType::class,'medicine_type_id');
    }

    public function ddmedicine()
    {
        return $this->belongsTo(DdMedicine::class,'medicine_id');
    }




}
