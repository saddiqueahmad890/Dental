<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
    'table_name',
    'record_id',
    'record_type',
    'file_name',
    'created_by',
    'updated_by'
    ];

}
