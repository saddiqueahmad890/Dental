<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewReport extends Model
{
    use HasFactory;

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function procedure(){
        return $this->belongsTo(DdProcedure::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function doctor(){
        return $this->belongsTo(DoctorDetail::class);
    }
}
