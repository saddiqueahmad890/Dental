<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsApi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'gateway',
        'auth_id',
        'auth_token',
        'api_id',
        'sender_number',
        'status'
    ];

}
