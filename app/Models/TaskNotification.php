<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'assign_by',
        'assign_to',
        'text',
        'url',
        'status',
        'created_by',
        'updated_by',
    ];

    // Define relationships if necessary
    public function assigner()
    {
        return $this->belongsTo(User::class, 'assign_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }
}
