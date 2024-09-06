<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountHeader extends Model
{
    use SoftDeletes,Loggable;

    protected $fillable = [
        'company_id',
        'name',
        'type',
        'description',
        'status'
    ];
    //  for log

}
