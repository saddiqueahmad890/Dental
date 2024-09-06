<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntraOral extends Model
{
    use HasFactory;

    protected $fillable = [
        'intra_oral_name',
        'status',
        'created_by',
        'updated_by',
    ];

    public function examInvestigation(){
        return $this->belongsTo(ExamInvestigation::class,'intra_oral_id','id');
    }
}
