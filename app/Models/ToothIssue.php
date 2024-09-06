<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToothIssue extends Model
{
    use HasFactory;
    protected $fillable = [
        'p_teeth_id', 'tooth_number', 'tooth_issue', 'description', 'created_by'
    ];

}
