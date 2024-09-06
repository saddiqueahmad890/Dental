<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryOfChiefComplaints extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_name',
        'status',
        'created_by',
        'updated_by',
    ];

    public function examInvestigation(){
        return $this->hasMany(ExamInvestigation::class,'history_chief_complaint_id','id');
    }

}
