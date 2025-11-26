<?php

namespace Tests\Feature\Controllers\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_get_users_list(): void
    {
        $user = $this->mockUser('testuser@admin.com');

        $autorizationHeader = $this->getAuthorizationHeader($user->email);

        $response = $this->withHeaders($autorizationHeader)->getJson($this->baseUrl . '/users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $this->assertNotEmpty($response->json('data'));
        $this->assertEquals(1, count($response->json('data')));
        $this->assertEquals('Test User', $response->json('data')[0]['name']);
        $this->assertEquals('testuser@admin.com', $response->json('data')[0]['email']);
    }

    public function test_get_users_list_with_user_receptionist(): void
    {
        $user = $this->mockUser('recepcao@reserva.com', 'recepcionista');

        $autorizationHeader = $this->getAuthorizationHeader($user->email);

        $response = $this->withHeaders($autorizationHeader)->getJson($this->baseUrl . '/users');

        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'This action is unauthorized.',
        ]);
    }

    public function test_get_users_list_with_filters(): void
    {
        $this->mockUser('testuser@admin.com');

        $filters = [
            'name' => 'Test User'
        ];

        $autorizationHeader = $this->getAuthorizationHeader('testuser@admin.com');

        $queryString = http_build_query($filters);
        $response = $this->withHeaders($autorizationHeader)->getJson("{$this->baseUrl}/users?{$queryString}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $this->assertNotEmpty($response->json('data'));
        $this->assertEquals(1, count($response->json('data')));
        $this->assertEquals('Test User', $response->json('data')[0]['name']);
        $this->assertEquals('testuser@admin.com', $response->json('data')[0]['email']);
    }

    public function test_get_users_list_with_no_matching_filters(): void
    {
        $this->mockUser('testuser@admin.com');

        $autorizationHeader = $this->getAuthorizationHeader('testuser@admin.com');

        $filters = "name=AKjasjkas";
        $response = $this->withHeaders($autorizationHeader)->getJson("{$this->baseUrl}/users?{$filters}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [],
        ]);

        $this->assertEmpty($response->json('data'));
    }

    public function test_user_without_authorization_token(): void
    {
        $response = $this->getJson($this->baseUrl . '/users');

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_get_user_details(): void
    {
        $user = $this->mockUser('testuser@admin.com');

        $autorizationHeader = $this->getAuthorizationHeader('testuser@admin.com');

        $response = $this->withHeaders($autorizationHeader)->getJson("{$this->baseUrl}/users/{$user->uuid}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'role',
                'status',
                'created_at',
                'updated_at',
            ],
        ]);
        $this->assertEquals('Test User', $response->json('data')['name']);
        $this->assertEquals('testuser@admin.com', $response->json('data')['email']);
    }

    public function test_get_user_details_with_recepcionista(): void
    {
        $user = $this->mockUser('recepcao@reserva.com', 'recepcionista');

        $autorizationHeader = $this->getAuthorizationHeader($user->email);

        $response = $this->withHeaders($autorizationHeader)->getJson("{$this->baseUrl}/users/{$user->uuid}");

        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'This action is unauthorized.',
        ]);
    }

    public function test_get_user_details_not_found(): void
    {
        $user = $this->mockUser('testuser@adminas.com');
        $autorizationHeader = $this->getAuthorizationHeader('testuser@adminas.com');

        $response = $this->withHeaders($autorizationHeader)->getJson("{$this->baseUrl}/users/nonexistent-uuid");

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'User not found',
        ]);
    }

    public function test_get_user_details_without_authorization_token(): void
    {
        $response = $this->getJson("{$this->baseUrl}/users/some-uuid");
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_create_user_with_recepcionista(): void
    {
        $user = $this->mockUser('recepcao@reserva.com', 'recepcionista');

        $autorizationHeader = $this->getAuthorizationHeader($user->email);

        $userData = [
            'name' => 'New User',
            'email' => 'newuser@admin.com',
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active',
        ];
        $response = $this->withHeaders($autorizationHeader)->postJson($this->baseUrl . '/users', $userData);

        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'This action is unauthorized.',
        ]);
    }

    public function test_create_user(): void
    {
        $autorizationHeader = $this->getAuthorizationHeader();

        $userData = [
            'name' => 'New User',
            'email' => 'newuser@admin.com',
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active',
        ];
        $response = $this->withHeaders($autorizationHeader)->postJson($this->baseUrl . '/users', $userData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'role',
                'status',
                'created_at',
                'updated_at',
            ],
        ]);
        $this->assertEquals('New User', $response->json('data')['name']);
        $this->assertEquals('newuser@admin.com', $response->json('data')['email']);
        $this->assertEquals('admin', $response->json('data')['role']);
        $this->assertEquals('active', $response->json('data')['status']);
    }

    public function test_create_user_validation_error(): void
    {
        $autorizationHeader = $this->getAuthorizationHeader();
        $userData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'role' => 'invalid-role',
        ];
        $response = $this->withHeaders($autorizationHeader)->postJson($this->baseUrl . '/users', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password', 'role']);
    }

    public function test_create_user_duplicate_email(): void
    {
        $this->mockUser('testuser@admin.com');

        $autorizationHeader = $this->getAuthorizationHeader();

        $userData = [
            'name' => 'Another User',
            'email' => 'testuser@admin.com',
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active',
        ];
        $response = $this->withHeaders($autorizationHeader)->postJson($this->baseUrl . '/users', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_create_user_without_authorization_token(): void
    {
        $userData = [
            'name' => 'New User',
            'email' => 'newuser@admin.com',
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active',
        ];
        $response = $this->postJson($this->baseUrl . '/users', $userData);
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_update_user(): void
    {
        $user = $this->mockUser('testuser@admin.com');

        $autorizationHeader = $this->getAuthorizationHeader();

        $response = $this->withHeaders($autorizationHeader)->putJson("{$this->baseUrl}/users/{$user->uuid}", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated Name', $response->json('data')['name']);
        $this->assertEquals('testuser@admin.com', $response->json('data')['email']);
        $this->assertEquals('admin', $response->json('data')['role']);
        $this->assertEquals('active', $response->json('data')['status']);
    }

    public function test_update_user_validation_error(): void
    {
        $user = $this->mockUser();

        $autorizationHeader = $this->getAuthorizationHeader();

        $response = $this->withHeaders($autorizationHeader)->putJson("{$this->baseUrl}/users/{$user->uuid}", [
            'email' => 'invalid-email',
            'role' => 'invalid-role',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'role']);
    }

    public function test_update_user_not_found(): void
    {
        $autorizationHeader = $this->getAuthorizationHeader();

        $response = $this->withHeaders($autorizationHeader)->putJson("{$this->baseUrl}/users/nonexistent-uuid", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'User not found',
        ]);
    }

    public function test_update_user_with_null_uuid(): void
    {
        $autorizationHeader = $this->getAuthorizationHeader();
        $response = $this->withHeaders($autorizationHeader)->putJson("{$this->baseUrl}/users/", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(405);
    }

    public function test_update_user_without_authorization_token(): void
    {
        $user = $this->mockUser();

        $response = $this->putJson("{$this->baseUrl}/users/{$user->uuid}", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_delete_user_not_found(): void
    {
        $autorizationHeader = $this->getAuthorizationHeader();
        $response = $this->withHeaders($autorizationHeader)->deleteJson("{$this->baseUrl}/users/nonexistent-uuid", []);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'User not found',
        ]);
    }

    public function test_delete_user(): void
    {
        $user = $this->mockUser();

        $autorizationHeader = $this->getAuthorizationHeader();
        $response = $this->withHeaders($autorizationHeader)->deleteJson("{$this->baseUrl}/users/{$user->uuid}", []);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => "User with name: {$user->name} deleted",
        ]);
    }

    public function test_delete_user_without_authorization_token(): void
    {
        $user = $this->mockUser();

        $response = $this->deleteJson("{$this->baseUrl}/users/{$user->uuid}", []);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_delete_user_with_null_uuid(): void
    {
        $autorizationHeader = $this->getAuthorizationHeader();
        $response = $this->withHeaders($autorizationHeader)->deleteJson("{$this->baseUrl}/users/", []);

        $response->assertStatus(405);
    }
}
