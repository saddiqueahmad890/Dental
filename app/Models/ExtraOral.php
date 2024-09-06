<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraOral extends Model
{
    use HasFactory;

    protected $fillable = [
        'extra_oral_name',
        'status',
        'created_by',
        'updated_by',
    ];    

    public function examInvestigation(){
        return $this->hasMany(ExamInvestigation::class,'extra_oral','id');
    }

}
