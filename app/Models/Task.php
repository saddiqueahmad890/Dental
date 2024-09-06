<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory,Loggable;

    protected $fillable = [
        'assign_to', 'assign_by', 'title', 'description', 'task_action', 'due_date', 'task_status_id', 'task_action_id', 'task_type_id', 'task_priority_id', 'status', 'created_by', 'updated_by'
    ];

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function assignBy()
    {
        return $this->belongsTo(User::class, 'assign_by');
    }

    public function taskPriority()
    {
        return $this->belongsTo(DdTaskPriority::class, 'task_priority_id');
    }

    public function taskStatus()
    {
        return $this->belongsTo(DdTaskStatus::class, 'task_status_id');
    }

    public function taskAction()
    {
        return $this->belongsTo(DdTaskAction::class, 'task_action_id');
    }

    public function taskType()
    {
        return $this->belongsTo(DdTaskType::class, 'task_type_id');
    }
}

