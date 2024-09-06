<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory,Loggable;
    protected $fillable=[
        'item_id',
        'category_id',
        'subcategory_id',
        'quantity',
        'unitprice',
        'created_by',
        'updated_by'
    ];

    public function inventoryConsumed(){
        return $this->hasMany(InventoryConsumed::class,'inventory_id','id');
    }

    public function item(){
        return $this->belongsTo(Item::class,'item_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }
}
