<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class RefreshDatabaseSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_one()
    {
        DB::table('users')->insert([
            'firstname' => 'A',
            'lastname' => 'B',
            'username' => 'u1',
            'password' => 'x',
            'privilege' => 'admin',
        ]);

        $this->assertEquals(1, DB::table('users')->count());
    }

    public function test_two()
    {
        dump(DB::table('users')->count());

        $this->assertEquals(0, DB::table('users')->count());
    }
}