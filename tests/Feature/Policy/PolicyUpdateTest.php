<?php

namespace Tests\Feature\Policy;

use App\Enums\PolicyAction;
use App\Enums\PolicyType;
use App\Models\Policy;
use App\Models\Users;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_update_policy_when_validation_failed(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->by($admin)
            ->create();

        $response = $this->from(route('admin.policies.edit', $policy))
            ->put(route('admin.policies.update', $policy), [
                'type' => '',
                'title' => '',
                'version' => '',
                'content_html' => '',
            ]);

        $response->assertRedirect(route('admin.policies.edit', $policy));

        $response->assertSessionHasErrors([
            'type',
            'title',
            'version',
            'content_html',
        ]);

        $this->assertDatabaseHas('policies', [
            'id' => $policy->id,
            'title' => $policy->title,
        ]);

        $this->assertDatabaseCount('policy_change_logs', 0);
    }

    public function test_admin_can_update_policy(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()->by($admin)->create();

        $response = $this->put(
            route('admin.policies.update', $policy),
            [
                'type' => PolicyType::PRIVACY->value,
                'title' => 'Privacy Policy New',
                'version' => '1.0.1',
                'content_html' => '<p>Updated</p>',
            ]
        );

        $response->assertRedirect();

        $this->assertDatabaseHas('policies', [
            'id' => $policy->id,
            'type' => PolicyType::PRIVACY->value,
            'title' => 'Privacy Policy New',
            'version' => '1.0.1',
            'updated_by' => $admin->id,
        ]);

        $this->assertDatabaseHas('policy_change_logs', [
            'policy_id' => $policy->id,
            'action' => PolicyAction::UPDATE->value,
            'created_by' => $admin->id,
        ]);
    }


    public function test_update_policy_creates_change_log(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->by($admin)
            ->create();

        $this->put(route('admin.policies.update', $policy), [
            'type' => PolicyType::PRIVACY->value,
            'title' => 'Updated Policy',
            'version' => '1.0.1',
            'content_html' => '<p>Updated</p>',
        ]);

        $this->assertDatabaseHas('policy_change_logs', [
            'policy_id' => $policy->id,
            'action' => PolicyAction::UPDATE->value,
            'created_by' => $admin->id,
        ]);
    }

    public function test_update_policy_does_not_change_created_by(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->by($admin)
            ->create();

        $this->put(route('admin.policies.update', $policy), [
            'type' => PolicyType::PRIVACY->value,
            'title' => 'Updated',
            'version' => '1.0.1',
            'content_html' => '<p>Updated</p>',
        ]);

        $policy->refresh();

        $this->assertEquals(
            $admin->id,
            $policy->created_by
        );
    }

    public function test_update_policy_changes_updated_by(): void
    {
        $creator = Users::factory()->admin()->create();

        $policy = Policy::factory()
            ->by($creator)
            ->create();

        $editor = $this->actingAsAdmin();

        $this->put(route('admin.policies.update', $policy), [
            'type' => PolicyType::PRIVACY->value,
            'title' => 'Updated',
            'version' => '1.0.1',
            'content_html' => '<p>Updated</p>',
        ]);

        $policy->refresh();

        $this->assertEquals(
            $creator->id,
            $policy->created_by
        );

        $this->assertEquals(
            $editor->id,
            $policy->updated_by
        );
    }
}