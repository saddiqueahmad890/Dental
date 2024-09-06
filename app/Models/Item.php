<?php

namespace App\Models;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory,Loggable;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'title',
        'description',
        'item_code',
        'quantity',
        'created_by',
        'updated_by',
        'status'
    ];

    // An Item belongs to a SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    // An Item belongs to a Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function inventory(){
        return $this->hasMany(Inventory::class);
    }

}
