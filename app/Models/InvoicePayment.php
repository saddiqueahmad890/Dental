<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory,Loggable;

    protected $fillable = [
        'invoice_id',
        'insurance_id',
        'paid_amount',
        'payment_type',
        'comments',
        'status'
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
}
