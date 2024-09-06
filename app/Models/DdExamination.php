<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdExamination extends Model
{
    use HasFactory,Loggable;

    protected $fillable = ['title', 'description', 'status', 'created_by', 'updated_by'];

    // Define relationships if necessary

}
