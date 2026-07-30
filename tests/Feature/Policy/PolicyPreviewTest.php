<?php

namespace Tests\Feature\Policy;

use App\Models\Policy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyPreviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_preview_page(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->draft()
            ->by($admin)
            ->create();

        $response = $this->get(
            route('admin.policies.preview', $policy)
        );

        $response->assertOk();

        $response->assertViewIs(
            'admin.policies.preview'
        );

        $response->assertViewHas('policy');
    }

    public function test_preview_displays_policy_information(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->draft()
            ->by($admin)
            ->create([
                'title' => 'Privacy Policy',
                'version' => '2.0.0',
                'content_html' => '<h1>Policy Content</h1>',
            ]);

        $response = $this->get(
            route('admin.policies.preview', $policy)
        );

        $response->assertOk();

        $response->assertSee('Privacy Policy');

        $response->assertSee('2.0.0');

        $response->assertSee(
            '<h1>Policy Content</h1>',
            false
        );
    }

    public function test_can_preview_draft_policy(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->draft()
            ->by($admin)
            ->create();

        $this->get(route('admin.policies.preview', $policy))
            ->assertOk();
    }

    public function test_can_preview_published_policy(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->published()
            ->by($admin)
            ->create();

        $this->get(route('admin.policies.preview', $policy))
            ->assertOk();
    }

    public function test_can_preview_archived_policy(): void
    {
        $admin = $this->actingAsAdmin();

        $policy = Policy::factory()
            ->archived()
            ->by($admin)
            ->create();

        $this->get(route('admin.policies.preview', $policy))
            ->assertOk();
    }
}
