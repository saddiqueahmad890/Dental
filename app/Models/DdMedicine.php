<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdMedicine extends Model
{
    use HasFactory,Loggable;

    protected $fillable = ['name', 'status','description', 'dd_medicine_type','updated_by','created_by'];

    public function type()
    {
        return $this->belongsTo(DdMedicineType::class);
    }

    public function medicineType()
    {
        return $this->belongsTo(DdMedicineType::class, 'dd_medicine_type', 'id');
    }
}
