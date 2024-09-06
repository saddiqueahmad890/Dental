<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftTissues extends Model
{
    use HasFactory;

    protected $fillable = [
        'soft_tissues_name',
        'status',
        'created_by',
        'updated_by',
    ];

    public function examInvestigation(){
        return $this->belongsTo(ExamInvestigation::class,'soft_tissue_id','id');
    }
    
}
