<?php

namespace App\Models;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table="dd_subcategories";
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'created_by',
        'updated_by',
        'status'
    ];

    // A SubCategory belongs to a Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // A SubCategory has many Items
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }
    



}
