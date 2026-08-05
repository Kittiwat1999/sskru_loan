<?php

namespace Tests\Feature\Policy;

use App\Models\Policy;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PolicyDataTableTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_admin_can_get_policy_datatable(): void
    {
        $this->actingAsAdmin();

        Policy::factory()->count(3)->create();

        $response = $this->getJson(
            route('admin.policies.data'),
            [
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        );

        $response->assertOk();
    }

    public function test_non_ajax_request_returns_404(): void
    {
        $this->actingAsAdmin();

        $response = $this->get(
            route('admin.policies.data')
        );

        $response->assertStatus(404);

        $response->assertJson([
            'error' => 'Not Found.'
        ]);
    }

    public function test_datatable_returns_correct_json_structure(): void
    {
        $this->actingAsAdmin();

        Policy::factory()->count(3)->create();

        $response = $this->getJson(
            route('admin.policies.data'),
            [
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        );

        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);
    }

    public function test_datatable_returns_correct_record_count(): void
    {
        $this->actingAsAdmin();

        Policy::factory()->count(5)->create();

        $response = $this->getJson(
            route('admin.policies.data'),
            [
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        );

        $json = $response->json();

        $this->assertGreaterThanOrEqual(
            5,
            $json['recordsTotal']
        );
    }

    public function test_datatable_contains_custom_columns(): void
    {
        $admin = $this->actingAsAdmin();

        Policy::factory()
            ->published()
            ->by($admin)
            ->create();

        $response = $this->getJson(
            route('admin.policies.data'),
            [
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'type',
                    'status',
                    'created_by',
                    'action',
                    'published'
                ]
            ]
        ]);
    }

    public function test_datatable_returns_creator_name(): void
    {
        $admin = $this->actingAsAdmin();

        Policy::factory()
            ->by($admin)
            ->create();

        $response = $this->getJson(
            route('admin.policies.data'),
            [
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        );

        $response->assertSee(
            $admin->firstname
        );

        $response->assertSee(
            $admin->lastname
        );
    }
}
