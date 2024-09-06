<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $fillable = [
        'record_id',
        'credit',
        'debit',
        'description',
        'customer_id'

    ];

}
