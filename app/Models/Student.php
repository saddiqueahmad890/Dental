<?php

namespace App\Models;
//use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLogs;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;

class Student extends Model
{
   // use SoftDeletes;

protected $fillable = [
    'id',

    'name',
    'department_id',
    'teacher_id',
    'course_id',
    'address',
    'dob',
    'photo'

];

public function department()
{
    return $this->belongsTo(HospitalDepartment::class);
}

public function teacher()
{
    return $this->belongsTo(Teacher::class);
}
public function course()
{
    return $this->belongsTo(Course::class);
}



}

