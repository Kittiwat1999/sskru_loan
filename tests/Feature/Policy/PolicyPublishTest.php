<?php

namespace Tests\Feature\Policy;

use App\Models\Policy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyPublishTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_publish_policy(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->draft()
            ->by($admin)
            ->create();

        $response = $this->post(
            route('admin.policies.publish', $policy)
        );

        $response->assertRedirect();
    }

    public function test_publish_changes_status_to_published(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->draft()
            ->by($admin)
            ->create();

        $this->post(route('admin.policies.publish', $policy));

        $policy->refresh();

        $this->assertEquals(
            'published',
            $policy->status
        );
    }

    public function test_publish_sets_published_at(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->draft()
            ->by($admin)
            ->create();

        $this->post(route('admin.policies.publish', $policy));

        $policy->refresh();

        $this->assertNotNull(
            $policy->published_at
        );
    }

    public function test_publish_sets_effective_at(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->draft()
            ->by($admin)
            ->create();

        $this->post(route('admin.policies.publish', $policy));

        $policy->refresh();

        $this->assertNotNull(
            $policy->effective_at
        );
    }

    public function test_publish_creates_change_log(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->draft()
            ->by($admin)
            ->create();

        $this->post(route('admin.policies.publish', $policy));

        $this->assertDatabaseHas('policy_change_logs', [
            'policy_id' => $policy->id,
            'action' => 'publish',
            'created_by' => $admin->id,
        ]);
    }

    public function test_cannot_publish_published_policy(): void
{
    $admin = $this->actingAsAdmin();

    $policy = Policy::factory()
        ->published()
        ->by($admin)
        ->create();

    $response = $this->post(
        route('admin.policies.publish', $policy)
    );

    $response->assertRedirect(
        route('admin.policies.index')
    );

    $response->assertSessionHas(
        'error',
        'สามารถ Publish ได้เฉพาะ Draft'
    );

    $policy->refresh();

    $this->assertEquals(
        'published',
        $policy->status
    );

    $this->assertNotNull($policy->published_at);

    $this->assertNotNull($policy->effective_at);

    $this->assertDatabaseMissing('policy_change_logs', [
        'policy_id' => $policy->id,
        'action' => 'publish',
    ]);
}
}
