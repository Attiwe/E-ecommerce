<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoginUser>
 */
class LoginUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'=>fake()->firstName,
            'last_name'=>fake()->lastName,
            'phone'=>fake()->phoneNumber,
            'email'=>fake()->email,
            'country'=>fake()->country,
            'password'=>fake()->password,
            'status'=> 1,
        ];
    }
}
