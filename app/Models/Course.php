<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use Loggable;
    protected $fillable = [
        'id',
        'course_name'
    ];

    public function teachers()
    {
        return $this->hasMany(TeacherCourse::class);
    }

}
