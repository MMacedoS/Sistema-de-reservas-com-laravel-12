<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function mockUser()
    {
        return User::factory()->create(
            [
                'name' => 'Test User',
                'email' => 'testuser@example.com',
                'role' => 'admin',
                'uuid' => '123e4567-e89b-12d3-a456-426614174000',
                'password' => bcrypt('password'),
                'status' => 'active',
            ]
        );
    }
}
