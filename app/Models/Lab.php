<?php

namespace App\Models;
use App\Models\UserLogs;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user',  // Ensure 'user' is listed here if it's an attribute in your 'labs' table
        'address',
        'lab_number',
        'phone_no',
        'created_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Assuming your table name is 'labs'
    protected $table = 'labs';

    // Assuming your primary key is 'id' and it's auto-incrementing
    protected $primaryKey = 'id';

    // Assuming you don't have timestamps in your table
    public $timestamps = false;


}
