<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\LoginUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'name' => fake()->words(2, true),  
         'Categore_id' => Category::inRandomOrder()->first()->id,  
         'brand_id' => Brand::inRandomOrder()->first()->id,  
        'description' => fake()->paragraph,  
        'color' => fake()->colorName, 
        'size' => fake()->randomElement(['S', 'M', 'L', 'XL']), 
        'slug' => fake()->slug, // توليد slug عشوائي
        'quantity' => fake()->numberBetween(1, 100), 
        'rating' => fake()->numberBetween(1, 5),  
        'discount' => 0, // قيمة الخصم 0
        'price' => fake()->randomFloat(2, 10, 500), 
        'images' => fake()->imageUrl(640, 480, ),  
        'status' => 1,  
    ];
}

}
