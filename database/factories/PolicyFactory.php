<?php

namespace Database\Factories;

use App\Enums\PolicyStatus;
use App\Enums\PolicyType;
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
            'status' => PolicyStatus::DRAFT->value,
            'effective_at' => null,
            'published_at' => null,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => PolicyStatus::PUBLISHED->value,
            'effective_at' => now(),
            'published_at' => now(),
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn () => [
            'status' => PolicyStatus::ARCHIVED->value,
        ]);
    }

    public function terms(): static
    {
        return $this->state(fn () => [
            'type' => PolicyType::TERMS->value,
        ]);
    }

    public function privacy(): static
    {
        return $this->state(fn () => [
            'type' => PolicyType::PRIVACY->value,
        ]);
    }

    public function pdpa(): static
    {
        return $this->state(fn () => [
            'type' => PolicyType::PDPA->value,
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
