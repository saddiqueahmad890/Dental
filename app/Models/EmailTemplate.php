<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\services\UserLogServices;
use App\Traits\Loggable;

class EmailTemplate extends Model
{
    use Loggable;
    protected $fillable = [
        'company_id',
        'name',
        'template'
    ];

}
