<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fname'=>fake()->name(),
            'lname'=>fake()->name(),
            'username'=>fake()->unique()->safeEmail(),
            'password'=>rand(0,99999999),
            'privilage'=>fake()->name()
        ];
    }
}
