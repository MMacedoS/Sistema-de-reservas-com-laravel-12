<?php

namespace Tests\Feature\Transformers\User;

use App\Transformers\UserTransformer;
use Tests\TestCase;

class UserTransformerTest extends TestCase
{
    private UserTransformer $userTransformer;

    public function setUp(): void
    {
        parent::setUp();
        $this->userTransformer = new UserTransformer();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_transform_user(): void
    {
        $user = $this->mockUser();

        $transformed = $this->userTransformer->transform($user);

        $this->assertIsArray($transformed);
        $this->assertArrayHasKey('id', $transformed);
        $this->assertArrayHasKey('name', $transformed);
        $this->assertArrayHasKey('email', $transformed);
        $this->assertArrayHasKey('role', $transformed);
        $this->assertArrayHasKey('status', $transformed);
        $this->assertEquals($user->uuid, $transformed['id']);
        $this->assertEquals($user->name, $transformed['name']);
        $this->assertEquals($user->email, $transformed['email']);
        $this->assertEquals($user->role, $transformed['role']);
        $this->assertEquals($user->status, $transformed['status']);
    }
}
