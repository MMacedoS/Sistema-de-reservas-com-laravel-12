<?php

namespace Tests\Feature\Repositories\User;

use App\Repositories\Entities\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_create_user(): void
    {
        $user = $this->mockUser();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role,
            'status' => $user->status,
        ]);
    }

    public function test_user_status_default_active(): void
    {
        $user = $this->mockUser();

        $this->assertEquals('active', $user->status);
    }

    public function test_create_user_with_params(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'gerente',
            'status' => 'active',
        ];

        $user = $this->userRepository->create($data);

        $this->assertNotNull($user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }
}
