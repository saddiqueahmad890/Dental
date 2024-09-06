<?php

namespace App\Models;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class EmailCampaignLog extends Model
{
    use Loggable;
    protected $fillable = [
        'user_id',
        'email_campaign_id',
        'smtp_configuration_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
