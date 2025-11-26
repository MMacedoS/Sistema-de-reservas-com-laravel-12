<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_login_with_valid_credentials(): void
    {
        $user = $this->mockUser("teste@admin.com");

        $credentials = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson($this->baseUrl . '/login', $credentials);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
        ]);
    }
}
