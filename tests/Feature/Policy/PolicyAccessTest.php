<?php

namespace Tests\Feature\Policy;

use App\Models\Policy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_policy_index(): void
    {
        $this->actingAsAdmin();

        $response = $this->get(route('admin.policies.index'));

        $response->assertOk();
    }

    public function test_admin_can_access_policy_create_page(): void
    {
        $this->actingAsAdmin();

        $response = $this->get(route('admin.policies.create'));

        $response->assertOk();
    }

    public function test_admin_can_access_policy_edit_page(): void
    {
        $this->actingAsAdmin();

        $policy = Policy::factory()->create();

        $response = $this->get(
            route('admin.policies.edit', $policy)
        );

        $response->assertOk();
    }
}