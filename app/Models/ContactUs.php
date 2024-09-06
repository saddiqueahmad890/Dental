<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use Loggable;
    protected $fillable = [
        'name',
        'email',
        'message'
    ];
}
