<?php

namespace App\Models;

use App\Notifications\OrderCreatedNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory ,Notifiable;

    protected $fillable = ['first_name','last_name','email','phone','country','address','status'];

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }

    protected static function booted()
    {
        static::created(function ($order) {
            $order->notify(new OrderCreatedNotification($order));
        });
    }
    
}
