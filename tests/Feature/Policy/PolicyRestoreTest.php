<?php

namespace Tests\Feature\Policy;

use App\Enums\PolicyAction;
use App\Enums\PolicyStatus;
use App\Models\Policy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyRestoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_restore_archived_policy(): void
{
    $admin = $this->actingAsAdmin();

    $policy = Policy::factory()
        ->archived()
        ->by($admin)
        ->create([
            'published_at' => now()->subDay(),
            'effective_at' => now()->subDay(),
        ]);

    $response = $this->post(
        route('admin.policies.restore', $policy)
    );

    $response->assertRedirect(
        route('admin.policies.index')
    );

    $response->assertSessionHas(
        'success',
        'คืนค่านโยบายสำเร็จ'
    );
}

public function test_restore_changes_status_to_draft(): void
{
    $admin = $this->actingAsAdmin();

    $policy = Policy::factory()
        ->archived()
        ->by($admin)
        ->create();

    $this->post(
        route('admin.policies.restore', $policy)
    );

    $policy->refresh();

    $this->assertEquals(
        PolicyStatus::DRAFT->value,
        $policy->status
    );
}

public function test_restore_keeps_publish_and_effective_datetime(): void
{
    $admin = $this->actingAsAdmin();

    $publishedAt = now()->subDays(2);
    $effectiveAt = now()->subDays(2);

    $policy = Policy::factory()
        ->archived()
        ->by($admin)
        ->create([
            'published_at' => $publishedAt,
            'effective_at' => $effectiveAt,
        ]);

    $this->post(
        route('admin.policies.restore', $policy)
    );

    $policy->refresh();

    $this->assertEquals(
        $publishedAt->toDateTimeString(),
        $policy->published_at->toDateTimeString()
    );

    $this->assertEquals(
        $effectiveAt->toDateTimeString(),
        $policy->effective_at->toDateTimeString()
    );
}

public function test_restore_creates_change_log(): void
{
    $admin = $this->actingAsAdmin();

    $policy = Policy::factory()
        ->archived()
        ->by($admin)
        ->create();

    $this->post(
        route('admin.policies.restore', $policy)
    );

    $this->assertDatabaseHas('policy_change_logs', [
        'policy_id' => $policy->id,
        'action' => PolicyAction::RESTORE->value,
        'created_by' => $admin->id,
    ]);
}

public function test_cannot_restore_draft_policy(): void
{
    $admin = $this->actingAsAdmin();

    $policy = Policy::factory()
        ->draft()
        ->by($admin)
        ->create();

    $response = $this->post(
        route('admin.policies.restore', $policy)
    );

    $response->assertRedirect(
        route('admin.policies.index')
    );

    $response->assertSessionHas(
        'error',
        'สามารถ Restore ได้เฉพาะ Archived'
    );

    $policy->refresh();

    $this->assertEquals('draft', $policy->status);

    $this->assertDatabaseMissing('policy_change_logs', [
        'policy_id' => $policy->id,
        'action' => PolicyAction::RESTORE->value,
    ]);
}

public function test_cannot_restore_published_policy(): void
{
    $admin = $this->actingAsAdmin();

    $policy = Policy::factory()
        ->published()
        ->by($admin)
        ->create();

    $response = $this->post(
        route('admin.policies.restore', $policy)
    );

    $response->assertRedirect(
        route('admin.policies.index')
    );

    $response->assertSessionHas(
        'error',
        'สามารถ Restore ได้เฉพาะ Archived'
    );

    $policy->refresh();

    $this->assertEquals(PolicyStatus::PUBLISHED->value, $policy->status);

    $this->assertDatabaseMissing('policy_change_logs', [
        'policy_id' => $policy->id,
        'action' => PolicyAction::RESTORE->value,
    ]);
}
}