<?php

namespace Tests;

use App\Models\Person\PessoaFisica;
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

    public function mockUser($email = 'testuser@example.com', $role = 'admin', $name = 'Test User'): User
    {
        return User::factory()->create(
            [
                'name' => $name,
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

    public function mockPessoaFisica(array $data = [
        'email' => 'testuser@example.com',
        'cpf' => '123.456.789-00',
        'name' => 'Test User',
        'data_nascimento' => '1990-01-01',
        'situacao' => 'ativo',
    ])
    {
        $user = $this->mockUser($data['email'] ?? 'testuser@example.com', 'admin', $data['name'] ?? 'Test User');

        $pessoaFisicaData =
            [
                'id_usuario' => $user->id,
                'nome' => $user->name,
                'cpf' => $data['cpf'] ?? '123.456.789-00',
                'data_nascimento' => $data['data_nascimento'] ?? '1990-01-01',
                'email' => $user->email,
                'telefone' => '(11) 91234-5678',
                'endereco' => 'Rua Teste, 123',
                'cidade' => 'Cidade Teste',
                'estado' => 'Estado Teste',
                'cep' => '12345-678',
                'genero' => 'Masculino',
                'estado_civil' => 'Solteiro',
                'profissao' => 'Desenvolvedor',
                'situacao' => $data['situacao'] ?? 'ativo',
            ];

        return PessoaFisica::factory()->create($pessoaFisicaData);
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
