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

    public function test_create_user_with_empty_params(): void
    {
        $data = [];

        $user = $this->userRepository->create($data);

        $this->assertNull($user);
    }

    public function test_update_user_status(): void
    {
        $user = $this->mockUser();

        $data = [
            'status' => 'inactive',
        ];

        $updatedUser = $this->userRepository->update($user->id, $data);

        $this->assertNotNull($updatedUser);
        $this->assertEquals('inactive', $updatedUser->status);
    }

    public function test_update_user_with_wrong_id(): void
    {
        $data = [
            'status' => 'inactive',
        ];

        $updatedUser = $this->userRepository->update(99, $data);

        $this->assertNull($updatedUser);
    }

    public function test_update_user_with_empty_data(): void
    {
        $user = $this->mockUser();

        $data = [];

        $updatedUser = $this->userRepository->update($user->id, $data);

        $this->assertNull($updatedUser);
    }

    public function test_create_user_with_missing_status(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'gerente',
        ];
        $user = $this->userRepository->create($data);

        $this->assertNotNull($user);
        $this->assertEquals('active', $user->status);
    }

    public function test_create_user_with_null_status(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'gerente',
            'status' => null,
        ];
        $user = $this->userRepository->create($data);
        $this->assertNotNull($user);
        $this->assertEquals('active', $user->status);
    }

    public function test_create_user_with_name_null(): void
    {
        $data = [
            'name' => null,
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'gerente',
            'status' => 'active',
        ];
        $user = $this->userRepository->create($data);
        $this->assertNull($user);
    }

    public function test_create_user_with_email_null(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => null,
            'password' => Hash::make('password'),
            'role' => 'gerente',
            'status' => 'active',
        ];
        $user = $this->userRepository->create($data);
        $this->assertNull($user);
    }

    public function test_create_user_with_password_null(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => null,
            'role' => 'gerente',
            'status' => 'active',
        ];
        $user = $this->userRepository->create($data);
        $this->assertNull($user);
    }

    public function test_delete_user(): void
    {
        $user = $this->mockUser();

        $this->userRepository->delete($user->id);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_delete_user_with_wrong_id(): void
    {
        $result = $this->userRepository->delete(99);

        $this->assertFalse($result);
    }
}
