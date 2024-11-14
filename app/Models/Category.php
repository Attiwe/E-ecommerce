<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;
      protected $fillable = ['subcategory_id','name','slug','status'];
      public function subcategor(){
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }
}
