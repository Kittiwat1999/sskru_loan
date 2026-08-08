<?php

namespace Tests\Unit\Services;

use App\Models\Policy;
use App\Models\Users;
use App\Services\PolicyAcceptanceService;
use Illuminate\Support\Facades\DB;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class PolicyAcceptanceServiceTest extends TestCase
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
    public function test_accept_create_all_policy_records()
    {
        $user = Users::factory()->create();

        Policy::factory()
            ->published()
            ->count(3)
            ->create();

        app(PolicyAcceptanceService::class)
            ->accept($user->id);

        $this->assertDatabaseCount(
            'policy_acceptances',
            3
        );
    }
}
