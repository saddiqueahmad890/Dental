<?php

namespace App\Models;

use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentStatus extends Model
{
    use HasFactory,Loggable;
    protected $table = "appointment_status";
    protected $fillable = ['id', 'name', 'status', 'created_by', 'updated_by'];


}
