<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{

    use HasFactory;
    protected $fillable = ['order_id','product_id','color','unit_amount','total_amount','quantity' ];

   public function order(){
    return $this->belongsTo(Order::class,'order_id');
   } 
   public function producte(){
    return $this->belongsTo(Product::class,'product_id'); 
   }

}
