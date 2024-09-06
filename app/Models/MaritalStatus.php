<?php

namespace App\Models;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    use HasFactory;
    protected $fillable = ['name','status','created_by','updated_by'];
}
