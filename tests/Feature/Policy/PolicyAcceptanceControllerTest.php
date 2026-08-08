<?php

namespace Tests\Feature\Policy;

use Tests\TestCase;
use App\Models\Policy;
use App\Enums\PolicyType;
use Illuminate\Support\Facades\DB;

class PolicyAcceptanceControllerTest extends TestCase
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
    /** @test */
    public function it_060_user_can_open_policy_acceptance_page(): void
    {
        $this->actingAsBorrower();

        Policy::factory()->published()->create([
            'type' => PolicyType::TERMS->value,
        ]);

        Policy::factory()->published()->create([
            'type' => PolicyType::PRIVACY->value,
        ]);

        Policy::factory()->published()->create([
            'type' => PolicyType::PDPA->value,
        ]);

        $response = $this->get(
            route('policies.acceptance')
        );

        $response->assertOk();
    }

    /** @test */
    public function it_062_preview_returns_404_when_published_policy_not_exists(): void
    {
        $this->actingAsBorrower();

        $response = $this->get(
            route(
                'policies.acceptance.show',
                PolicyType::TERMS->value
            )
        );

        $response->assertNotFound();
    }

    /** @test */
    public function it_063_acceptance_page_only_contains_published_policies(): void
    {
        $this->actingAsBorrower();

        Policy::factory()->published()->create([
            'type' => PolicyType::TERMS->value,
        ]);

        Policy::factory()->draft()->create([
            'type' => PolicyType::PRIVACY->value,
        ]);

        Policy::factory()->archived()->create([
            'type' => PolicyType::PDPA->value,
        ]);

        $response = $this->get(
            route('policies.acceptance')
        );

        $response->assertOk();

        $response->assertViewHas('policies', function ($policies) {
            return $policies->count() === 1
                && $policies->first()->type === PolicyType::TERMS->value;
        });
    }
}
