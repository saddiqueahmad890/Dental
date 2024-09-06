<?php

namespace App\Models;

use App\Models\UserLogs;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'weekday',
        'status',
        'created_by',
        'updated_by'
    ];

    /**
     * Get the user associated with the doctor schedule.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
