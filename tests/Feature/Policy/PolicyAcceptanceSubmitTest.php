<?php

namespace Tests\Feature\Policy;

use Tests\TestCase;
use App\Models\Policy;
use App\Models\Users;
use App\Models\PolicyAcceptance;
use App\Enums\PolicyStatus;
use App\Services\PublishedPolicyCacheService;
use Illuminate\Support\Facades\DB;

class PolicyAcceptanceSubmitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        \App\Models\PolicyAcceptance::truncate();
        \App\Models\Policy::truncate();
        \App\Models\Users::truncate();
        \App\Models\PolicyChangeLog::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function createPublishedPolicies(): void
    {
        Policy::factory()->create([
            'type' => 'terms',
            'version' => '1.0.0',
            'status' => PolicyStatus::PUBLISHED->value,
        ]);

        Policy::factory()->create([
            'type' => 'privacy',
            'version' => '1.0.0',
            'status' => PolicyStatus::PUBLISHED->value,
        ]);

        Policy::factory()->create([
            'type' => 'pdpa',
            'version' => '1.0.0',
            'status' => PolicyStatus::PUBLISHED->value,
        ]);
    }


    public function test_user_can_accept_all_published_policy(): void
    {
        $user = Users::factory()->create();

        $this->withSession([
            'user_id' => $user->id,
        ]);

        $this->createPublishedPolicies();

        $response = $this->post(
            route('policies.acceptance.accept'),
            [
                'accepted' => true
            ]
        );

        $response->assertRedirect();

        $this->assertDatabaseCount(
            'policy_acceptances',
            3
        );

        $this->assertDatabaseHas(
            'policy_acceptances',
            [
                'user_id' => $user->id,
                'policy_type' => 'terms',
                'policy_version' => '1.0.0',
            ]
        );
    }

    public function test_user_cannot_accept_without_checkbox(): void
    {
        $user = Users::factory()->create();

        $this->withSession([
            'user_id' => $user->id,
        ]);

        $this->createPublishedPolicies();

        $response = $this->post(
            route('policies.acceptance.accept'),
            []
        );

        $response->assertSessionHasErrors([
            'accepted'
        ]);

        $this->assertDatabaseCount(
            'policy_acceptances',
            0
        );
    }

    public function test_guest_cannot_accept_policy(): void
    {
        $this->createPublishedPolicies();

        $response = $this->post(
            route('policies.acceptance.accept'),
            [
                'accepted' => true
            ]
        );

        $response->assertRedirect(
            route('login')
        );
    }

    public function test_user_accept_policy_twice_should_not_duplicate()
    {
        $user = Users::factory()->create();

        $this->withSession([
            'user_id' => $user->id,
        ]);

        $this->createPublishedPolicies();

        $this->post(
            route('policies.acceptance.accept'),
            [
                'accepted' => true
            ]
        );

        $this->post(
            route('policies.acceptance.accept'),
            [
                'accepted' => true
            ]
        );

        $this->assertDatabaseCount(
            'policy_acceptances',
            3
        );
    }

    public function test_new_policy_version_requires_new_acceptance()
    {
        $user = Users::factory()->create();

        $policy = Policy::factory()->published()->create([
            'type' => 'terms',
            'version' => '1.0.0',
        ]);

        PolicyAcceptance::create([
            'user_id' => $user->id,
            'policy_id' => $policy->id,
            'policy_type' => $policy->type,
            'policy_version' => '1.0.0',
            'accepted_at' => now(),
        ]);

        $policy->update([
            'version' => '1.1.0',
        ]);

        $this->withSession([
            'user_id' => $user->id,
        ]);

        $this->post(
            route('policies.acceptance.accept'),
            [
                'accepted' => true
            ]
        );

        $this->assertDatabaseHas(
            'policy_acceptances',
            [
                'policy_version' => '1.1.0'
            ]
        );
    }
}
