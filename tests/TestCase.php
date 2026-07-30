<?php

namespace Tests;

use App\Models\Users;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected function actingAsAdmin(): Users
    {
        return $this->actingAsPrivilege('admin');
    }


    protected function actingAsApprover(): Users
    {
        return $this->actingAsPrivilege('approver');
    }


    protected function actingAsTeacher(): Users
    {
        return $this->actingAsPrivilege('teacher');
    }


    protected function actingAsBorrower(): Users
    {
        return $this->actingAsPrivilege('borrower');
    }


    protected function actingAsPrivilege(string $privilege): Users
    {
        $user = Users::factory()
            ->state([
                'privilege' => $privilege
            ])
            ->create();

        $this->withSession([
            'user_id' => $user->id,
            'privilege' => $user->privilege,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'last_activity_time' => now()->timestamp,
        ]);

        return $user;
    }
}
