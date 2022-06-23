<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'categories_id', 'price', 'qty', 'description', 'slug', 'code'];

    protected $hidden = [];

    public function scopeFilter($query, array $filters)
    {


        $query->when($filters['key'] ?? false, function ($query, $key) {
            return $query->where('name', 'like', '%' . $key . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });
    }
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id')->withTrashed();
    }
    public function carts()
    {
        return $this->hasMany(Cart::class, 'products_id', 'id');
    }
}
