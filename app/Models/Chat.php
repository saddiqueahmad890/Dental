<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory,Loggable;

    protected $fillable = [
        'task_id',
        'user_id',
        'message',
        'status',
        'created_by',
        'updated_by',
    ];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
