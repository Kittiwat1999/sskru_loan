<?php

namespace Database\Factories;

use App\Models\Policy;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PolicyAcceptance>
 */
class PolicyAcceptanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'accepted_at' => now(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),

        ];
    }
    public function by(Users $user): static
    {
        return $this->state(fn() => [
            'user_id' => $user->id,
        ]);
    }
public function forPolicy(Policy $policy): static
{
    return $this->state(fn () => [
        'policy_id' => $policy->id,
        'policy_type' => $policy->type_enum->value,
        'policy_version' => $policy->version,
    ]);
}
}
