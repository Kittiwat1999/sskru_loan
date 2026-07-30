<?php

namespace Database\Factories;

use App\Models\Policy;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Policy>
 */
class PolicyFactory extends Factory
{
     protected $model = Policy::class;

    public function definition(): array
    {
        $user = Users::factory()->create();

        return [
            'type' => 'terms',
            'title' => fake()->sentence(4),
            'version' => '1.0.0',
            'content_html' => fake()->paragraph(),
            'status' => 'draft',
            'effective_at' => null,
            'published_at' => null,
            'created_by' => Users::factory(),
            'updated_by' => Users::factory(),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => 'draft',
            'effective_at' => null,
            'published_at' => null,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => 'published',
            'effective_at' => now(),
            'published_at' => now(),
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn () => [
            'status' => 'archived',
        ]);
    }

    public function terms(): static
    {
        return $this->state(fn () => [
            'type' => 'terms',
        ]);
    }

    public function privacy(): static
    {
        return $this->state(fn () => [
            'type' => 'privacy',
        ]);
    }

    public function pdpa(): static
    {
        return $this->state(fn () => [
            'type' => 'pdpa',
        ]);
    }

    public function by (Users $user): static
    {
        return $this->state(fn () => [
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }
}
