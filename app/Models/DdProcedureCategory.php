<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLogs;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Auth;
class DdProcedureCategory extends Model
{
    use HasFactory,Loggable;
    protected $fillable = [
        'id',
        'title',
        'description',
        'created_by',
        'updated_by'

    ];

}
