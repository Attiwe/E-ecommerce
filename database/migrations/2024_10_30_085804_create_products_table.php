<?php

use App\Models\Category;
use App\Models\LoginUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loginUser_id')->constrained('login_users')->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete() ;
            $table->foreignId('Categore_id')->constrained('categories')->cascadeOnUpdate();
            $table->string('name');
            $table->text('description');
            $table->string('color');
            $table->string('size');
            $table->string('slug');
            $table->integer('quantity');
            $table->integer('rating');
            $table->integer('discount');
            $table->decimal('price',10,2);
            $table->string('image');
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
