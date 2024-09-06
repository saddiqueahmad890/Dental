<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    protected $fillable = [
        'user_id', // Add this line
        'action',
        'record_id',
        'field_name',
        'description',
        'table_name',
        'old_value',
        'new_value',
    ];

    public function user()

{
    return $this->belongsTo(User::class,'user_id');
}


public function department()

{
    return $this->belongsTo(HospitalDepartment::class,'user_id');
}
}
