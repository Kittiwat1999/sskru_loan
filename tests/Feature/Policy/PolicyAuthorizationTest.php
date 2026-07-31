<?php

namespace Tests\Feature\Policy;

use App\Enums\PolicyType;
use App\Models\Policy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_borrower_cannot_access_policy_index(): void
    {
        $this->actingAsBorrower();

        $this->get(route('admin.policies.index'))
            ->assertNotFound();
    }

    public function test_teacher_cannot_access_policy_index(): void
    {
        $this->actingAsTeacher();

        $this->get(route('admin.policies.index'))
            ->assertNotFound();
    }


    public function test_approver_cannot_access_policy_index(): void
    {
        $this->actingAsApprover();

        $this->get(route('admin.policies.index'))
            ->assertNotFound();
    }

    public function test_borrower_cannot_create_policy(): void
    {
        $this->actingAsBorrower();

        $this->get(route('admin.policies.create'))
            ->assertNotFound();
    }

    public function test_borrower_cannot_store_policy(): void
    {
        $this->actingAsBorrower();
        $data = [
            'type' => PolicyType::TERMS->value,
            'title' => 'ข้อกำหนดการใช้งานระบบ',
            'version' => '1.0.0',
            'content_html' => '<p>เนื้อหานโยบาย</p>',
        ];
        $this->post(route('admin.policies.store'), $data)->assertNotFound();
    }
}
