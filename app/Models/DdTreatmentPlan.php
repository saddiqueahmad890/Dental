<?php

namespace App\Models;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdTreatmentPlan extends Model
{
    use HasFactory,Loggable;

    protected $fillable = ['title', 'description', 'status', 'created_by', 'updated_by'];


}
