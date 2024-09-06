<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Model;

class FrontEnd extends Model
{
    protected $fillable = [
        'page',
        'content',
        'status'
    ];

}
