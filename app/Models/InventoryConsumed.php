<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryConsumed extends Model
{
    protected $table = 'inventory_consumeds';

    protected $primaryKey = 'id';

    protected $fillable = [
        'quantity',
        'inventory_id',
        'created_by', 
    ];
    public $timestamps = true;

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
