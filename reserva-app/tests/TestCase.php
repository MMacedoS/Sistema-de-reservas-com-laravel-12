<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    public string $baseUrl = '/api/v1';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function mockUser($email = 'testuser@example.com', $role = 'admin'): User
    {
        return User::factory()->create(
            [
                'name' => 'Test User',
                'email' => $email,
                'role' => $role,
                'uuid' => Str::uuid()->toString(),
                'password' => bcrypt('password'),
                'status' => 'active',
            ]
        );
    }

    public function mockUsers(int $count = 5, $role = 'gerente')
    {
        return User::factory()->count($count)->create(
            [
                'uuid' => Str::uuid()->toString(),
                'role' => $role,
                'status' => 'active',
            ]
        );
    }

    public function getAuthorizationHeader($email = 'teste@admin.com'): array
    {
        $user = DB::table('users')->whereEmail($email)->first();
        if (!$user) {
            $user = $this->mockUser($email);
        }

        $credentials = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson($this->baseUrl . '/login', $credentials);

        return [
            'Authorization' => 'Bearer ' . $response->json('access_token'),
        ];
    }
}
