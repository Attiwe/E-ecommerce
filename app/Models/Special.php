<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $fillable =['login_id','name','price','discount','quantity','rating','image','size','status'];
    
    public function login(){
        return $this->belongsTo(LoginUser::class,'login_id');
    }
}
