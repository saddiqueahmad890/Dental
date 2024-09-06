<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'id',
        'name',
        'address'
    ];

    public function courses()
    {
        return $this->hasMany(TeacherCourse::class);
    }

}
