<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLogs;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;


class Payment extends Model
{
    protected $fillable = [
        'company_id',
        'account_name',
        'account_type',
        'payment_date',
        'receiver_name',
        'description',
        'amount',
        'created_by',
        'updated_by'
    ];


}
