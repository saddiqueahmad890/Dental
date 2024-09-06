<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquirySource extends Model
{
    use HasFactory;

    protected $fillable = ['source_name', 'created_by', 'updated_by'];

    // Define relationships if necessary

}
