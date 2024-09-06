<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardTissue extends Model
{
    use HasFactory;

    protected $fillable = [
        'soft_tissues_name',
        'status',
        'created_by',
        'updated_by',
    ];

    public function examInvestigation(){
        return $this->hasMany(ExamInvestigation::class,'soft_tissue_id','id');
    }

}
