<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLogs;
use App\services\UserLogServices;
use App\Traits\Loggable;

class DdTaskPriority extends Model
{
    use HasFactory,Loggable;
    protected $table= "dd_task_priorities";

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'created_by',
        'updated_by',

    ];


}
