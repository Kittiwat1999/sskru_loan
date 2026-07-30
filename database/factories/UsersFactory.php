<?php

namespace Database\Factories;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    protected $model = Users::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'privilege' => 'borrower',
            'prefix' => 'นาย',
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'password' => Hash::make('password'),
            'activated' => true,
            'isactive' => true,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'privilege' => 'admin',
        ]);
    }

    public function approver(): static
    {
        return $this->state(fn () => [
            'privilege' => 'approver',
        ]);
    }

    public function teacher(): static
    {
        return $this->state(fn () => [
            'privilege' => 'teacher',
        ]);
    }

    public function borrower(): static
    {
        return $this->state(fn () => [
            'privilege' => 'borrower',
        ]);
    }
}
