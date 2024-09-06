<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdTaskAction extends Model
{
    use HasFactory,Loggable;
    protected $table="dd_task_actions";

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'created_by',
        'updated_by',

    ];


}
