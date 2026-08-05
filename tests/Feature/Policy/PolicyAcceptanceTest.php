<?php

namespace Tests\Feature\Policy;

use Tests\TestCase;
use App\Models\Users;
use App\Models\Policy;
use App\Models\PolicyAcceptance;
use App\DTO\PublishedPolicyVersionData;
use App\Services\PolicyAcceptanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyAcceptanceTest extends TestCase
{
    use RefreshDatabase;


    /**
     * IT-049
     * Accept policy should create acceptance record
     */
    public function test_can_accept_policy(): void
    {
        $service = app(
            PolicyAcceptanceService::class
        );

        $user = Users::factory()->create();

        $policy = Policy::factory()
            ->published()
            ->create();

        $acceptance = $service->accept(
            $user->id,
            $policy,
            '127.0.0.1',
            'PHPUnit'
        );

        $this->assertDatabaseHas(
            'policy_acceptances',
            [
                'id' => $acceptance->id,
                'user_id' => $user->id,
                'policy_id' => $policy->id,
            ]
        );
    }


    /**
     * IT-050
     * Acceptance should store policy snapshot
     */
    public function test_accept_policy_stores_snapshot(): void
    {
        $service = app(
            PolicyAcceptanceService::class
        );

        $user = Users::factory()->create();

        $policy = Policy::factory()
            ->published()
            ->create();

        $acceptance = $service->accept(
            $user->id,
            $policy,
            '127.0.0.1',
            'PHPUnit'
        );

        $this->assertEquals(
            $policy->id,
            $acceptance->policy_id
        );

        $this->assertEquals(
            $policy->type,
            $acceptance->policy_type
        );

        $this->assertEquals(
            $policy->version,
            $acceptance->policy_version
        );
    }


    /**
     * IT-051
     * User has accepted policy
     */
    public function test_has_accepted_returns_true_after_accept(): void
    {
        $service = app(
            PolicyAcceptanceService::class
        );

        $user = Users::factory()->create();

        $policy = Policy::factory()
            ->published()
            ->create();

        $service->accept(
            $user->id,
            $policy,
            '127.0.0.1',
            'PHPUnit'
        );

        $dto = PublishedPolicyVersionData::fromPolicy(
            $policy
        );

        $this->assertTrue(
            $service->hasAccepted(
                $user->id,
                $dto
            )
        );
    }

    /**
     * IT-052
     * User has not accepted policy
     */
    public function test_has_accepted_returns_false_when_not_accept(): void
    {
        $service = app(
            PolicyAcceptanceService::class
        );

        $user = Users::factory()->create();

        $policy = Policy::factory()
            ->published()
            ->create();

        $dto = PublishedPolicyVersionData::fromPolicy(
            $policy
        );

        $this->assertFalse(
            $service->hasAccepted(
                $user->id,
                $dto
            )
        );
    }


    /**
     * IT-053
     * Accepting same policy twice should return same record
     */
    public function test_accept_same_policy_twice_returns_existing_record(): void
    {
        $service = app(
            PolicyAcceptanceService::class
        );

        $user = Users::factory()->create();

        $policy = Policy::factory()
            ->published()
            ->create();

        $first = $service->accept(
            $user->id,
            $policy,
            '127.0.0.1',
            'PHPUnit'
        );

        $second = $service->accept(
            $user->id,
            $policy,
            '127.0.0.1',
            'PHPUnit'
        );

        $this->assertEquals(
            $first->id,
            $second->id
        );

        $this->assertSame(
            1,
            PolicyAcceptance::query()
                ->where('user_id', $user->id)
                ->where('policy_id', $policy->id)
                ->count()
        );
    }

    /**
     * IT-054
     * Different policy should not be treated as accepted
     */
    public function test_accepting_one_policy_does_not_accept_other_policy(): void
    {
        $service = app(
            PolicyAcceptanceService::class
        );

        $user = Users::factory()->create();

        $policyA = Policy::factory()
            ->published()
            ->create();

        $policyB = Policy::factory()
            ->published()
            ->create();

        $service->accept(
            $user->id,
            $policyA,
            '127.0.0.1',
            'PHPUnit'
        );

        $dto = PublishedPolicyVersionData::fromPolicy(
            $policyB
        );

        $this->assertFalse(
            $service->hasAccepted(
                $user->id,
                $dto
            )
        );
    }
}