<?php

namespace App\Models;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,Loggable;
    protected $table="dd_categories";
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'updated_by',
        'status'
    ];

    // A Category has many SubCategories
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    // A Category has many Items through SubCategories
    public function items()
    {
        return $this->hasManyThrough(Item::class, SubCategory::class);
    }

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }




}
