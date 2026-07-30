<?php

namespace Tests\Feature\Policy;

use App\Models\Policy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyArchiveTest extends TestCase
{
    use RefreshDatabase;
    public function test_admin_can_archive_policy(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->published()
            ->by($admin)
            ->create();

        $response = $this->post(
            route('admin.policies.archive', $policy)
        );

        $response->assertRedirect(
            route('admin.policies.index')
        );

        $response->assertSessionHas(
            'success',
            'จัดเก็บนโยบายสำเร็จ'
        );
    }

    public function test_archive_changes_status_to_archived(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->published()
            ->by($admin)
            ->create();

        $this->post(
            route('admin.policies.archive', $policy)
        );

        $policy->refresh();

        $this->assertEquals(
            'archived',
            $policy->status
        );
    }

    public function test_archive_creates_change_log(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->published()
            ->by($admin)
            ->create();

        $this->post(
            route('admin.policies.archive', $policy)
        );

        $this->assertDatabaseHas('policy_change_logs', [
            'policy_id' => $policy->id,
            'action' => 'archive',
            'created_by' => $admin->id,
        ]);
    }


    public function test_cannot_archive_draft_policy(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->draft()
            ->by($admin)
            ->create();

        $response = $this->post(
            route('admin.policies.archive', $policy)
        );

        $response->assertRedirect(
            route('admin.policies.index')
        );

        $response->assertSessionHas(
            'error',
            'สามารถ Archive ได้เฉพาะ Published'
        );

        $policy->refresh();

        $this->assertEquals(
            'draft',
            $policy->status
        );

        $this->assertDatabaseMissing('policy_change_logs', [
            'policy_id' => $policy->id,
            'action' => 'archive',
        ]);
    }

    public function test_cannot_archive_archived_policy(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->archived()
            ->by($admin)
            ->create();

        $response = $this->post(
            route('admin.policies.archive', $policy)
        );

        $response->assertRedirect(
            route('admin.policies.index')
        );

        $response->assertSessionHas(
            'error',
            'สามารถ Archive ได้เฉพาะ Published'
        );

        $policy->refresh();

        $this->assertEquals(
            'archived',
            $policy->status
        );

        $this->assertDatabaseMissing('policy_change_logs', [
            'policy_id' => $policy->id,
            'action' => 'archive',
        ]);
    }
}
