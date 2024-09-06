<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_from',
        'notification_to',
        'text',
        'url',
        'created_by',
        'updated_by',
        'status',
        'read_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'notification_from');
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'read_at' => 'datetime',
    ];

}
