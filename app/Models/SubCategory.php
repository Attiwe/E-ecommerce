<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable=['categre_id','name','slug','image','status'];

    public function categres(){
        return $this->belongsTo(Category::class,'categre_id');
    }
}
