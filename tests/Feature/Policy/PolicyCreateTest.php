<?php

namespace Tests\Feature\Policy;

use App\Models\Policy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_policy(): void
    {
        $admin = $this->actingAsAdmin();

        $data = [
            'type' => 'terms',
            'title' => 'ข้อกำหนดการใช้งานระบบ',
            'version' => '1.0.0',
            'content_html' => '<p>เนื้อหานโยบาย</p>',
        ];

        $response = $this->post(
            route('admin.policies.store'),
            $data
        );

        $response->assertRedirect();

        $this->assertDatabaseHas('policies', [
            'type' => 'terms',
            'title' => 'ข้อกำหนดการใช้งานระบบ',
            'version' => '1.0.0',
            'status' => 'draft',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        $this->assertDatabaseHas('policy_change_logs', [
            'action' => 'create',
            'created_by' => $admin->id,
        ]);
    }

    public function test_create_policy_validation_failed_when_required_fields_are_missing(): void
    {
        $this->actingAsAdmin();

        $response = $this->from(route('admin.policies.create'))
            ->post(route('admin.policies.store'), []);

        $response->assertRedirect(route('admin.policies.create'));

        $response->assertSessionHasErrors([
            'type',
            'title',
            'version',
            'content_html',
        ]);

        $this->assertDatabaseCount('policies', 0);
        $this->assertDatabaseCount('policy_change_logs', 0);
    }

    public function test_create_policy_validation_failed_when_type_is_invalid(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.policies.store'), [
            'type' => 'invalid',
            'title' => 'Test',
            'version' => '1.0.0',
            'content_html' => '<p>Test</p>',
        ]);

        $response->assertSessionHasErrors('type');

        $this->assertDatabaseCount('policies', 0);
    }

    public function test_create_policy_validation_failed_when_title_exceeds_max_length(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.policies.store'), [
            'type' => 'terms',
            'title' => str_repeat('A', 256),
            'version' => '1.0.0',
            'content_html' => '<p>Test</p>',
        ]);

        $response->assertSessionHasErrors('title');

        $this->assertDatabaseCount('policies', 0);
    }
}