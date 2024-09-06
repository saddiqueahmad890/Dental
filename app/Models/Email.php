<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
use HasFactory,Loggable;

protected $fillable = [
'recipient',
'subject',
'body',
'status',
'created_by',
'updated_by'
];

public $timestamps = true;

protected $dates = ['created_at', 'updated_at'];
}
