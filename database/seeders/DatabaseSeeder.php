<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\LoginUser;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    //  LoginUser::factory(100)->create();
    // SubCategory::factory(50)->create();
    //  Category::factory(100)->create();
        // Brand::factory(100)->create();
        // Product::factory(100)->create();
     Order::factory(100)->create();
     OrderItems::factory(100)->create();


    }
}
 