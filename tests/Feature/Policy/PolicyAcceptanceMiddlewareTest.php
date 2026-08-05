<?php

namespace Tests\Feature\Policy;

use Tests\TestCase;
use App\Models\Policy;
use App\Models\Users;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPolicyAcceptance;
use App\Services\PolicyAcceptanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyAcceptanceMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {

        parent::setUp();

        Cache::flush();

        Route::get('/test-policy-check', function () {

            return response()->json([
                'message' => 'passed',
            ]);
        })->middleware([
            'web',
            CheckPolicyAcceptance::class,
        ]);

    }

    /**
     * IT-057
     */
    public function test_user_can_pass_when_no_published_policy_exists(): void
    {
        
        $user = Users::factory()->create();

        $response = $this
            ->withSession([
                'user_id' => $user->id,
                'privilege' => $user->privilege,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
            ])
            ->get('/test-policy-check');

        $response->assertOk();

        $response->assertJson([
            'message' => 'passed',
        ]);
    }

    /**
     * IT-055
     */
    public function test_user_can_pass_when_all_published_policy_are_accepted(): void
    {

        $user = Users::factory()->create();

        $policies = collect([
            Policy::factory()->published()->create([
                'type' => 'terms',
            ]),
            Policy::factory()->published()->create([
                'type' => 'privacy',
            ]),
            Policy::factory()->published()->create([
                'type' => 'pdpa',
            ]),
        ]);

        $service = app(
            PolicyAcceptanceService::class
        );

        foreach ($policies as $policy) {

            $service->accept(
                $user->id,
                $policy,
                '127.0.0.1',
                'PHPUnit'
            );
        }

        Cache::flush();

        $response = $this
            ->withSession([
                'user_id' => $user->id,
                'privilege' => $user->privilege,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
            ])
            ->get('/test-policy-check');

        $response->assertOk();

        $response->assertJson([
            'message' => 'passed',
        ]);
    }

    /**
     * IT-056
     */
    public function test_user_cannot_pass_when_missing_policy_acceptance(): void
    {
        $user = Users::factory()->create();

        $policies = collect([
            Policy::factory()->published()->create([
                'type' => 'terms',
            ]),
            Policy::factory()->published()->create([
                'type' => 'privacy',
            ]),
            Policy::factory()->published()->create([
                'type' => 'pdpa',
            ]),
        ]);

        $service = app(
            PolicyAcceptanceService::class
        );

        foreach ($policies->take(2) as $policy) {

            $service->accept(
                $user->id,
                $policy,
                '127.0.0.1',
                'PHPUnit'
            );
        }

        Cache::flush();

        $response = $this
            ->withSession([
                'user_id' => $user->id,
                'privilege' => $user->privilege,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
            ])
            ->get('/test-policy-check');

        $response->assertRedirect(
            route('policies.acceptance')
        );
    }

    /**
     * IT-058
     */
    public function test_guest_cannot_pass_policy_middleware(): void
    {
        Cache::flush();

        $response = $this->get(
            '/test-policy-check'
        );

        $response->assertRedirect(
            route('login')
        );
    }
}
