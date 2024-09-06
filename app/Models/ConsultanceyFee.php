<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultanceyFee extends Model
{
    use HasFactory,Loggable;


    protected $fillable = [
        'user_id',
        'date',
        'amount',
        'description',
        'updated_by',
        'created_by',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
