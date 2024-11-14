<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'loginUser_id', 'brand_id', 'Categore_id',
        'description', 'color', 'size', 'slug', 'quantity', 
        'rating', 'discount', 'price', 'images', 'status', 
     ];
   
    protected $casts = ['images' => 'array'];

    public function getFinalPriceAttribute()
    {
        return round($this->price - ($this->price * ($this->discount / 100)), 2);
    }

    public function getTotalPriceAttribute()
    {
        return round($this->final_price * ($this->quantity ?: 1), 2);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function categore()
    {
        return $this->belongsTo(Category::class, 'Categore_id');
    }
}
