<?php

namespace Tests\Feature\Repositories\Person;

use App\Repositories\Entities\Person\PessoaFisicaRepository;
use Tests\TestCase;

class PessoaFisicaRepositoryTest extends TestCase
{
    private PessoaFisicaRepository $pessoaFisicaRepository;

    public function setUp(): void
    {
        $this->pessoaFisicaRepository = new PessoaFisicaRepository();
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_all_method_returns_all_pessoas_fisicas(): void
    {
        $pessoa_fisica = $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $this->assertTrue(true);
        $this->assertDatabaseHas('pessoa_fisica', [
            'id' => $pessoa_fisica->id,
            'email' => $pessoa_fisica->email,
        ]);
        $this->assertEquals($pessoa_fisica->cpf, '123.456.789-10');
        $this->assertEquals($pessoa_fisica->data_nascimento, '1991-01-01');
        $this->assertEquals($pessoa_fisica->nome, 'Test User');
    }

    public function test_all_method_creates_new_pessoa_fisica(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri01@example.com',
                'cpf' => '123.456.789-11',
                'name' => 'Test User 1',
                'data_nascimento' => '1995-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri02@example.com',
                'cpf' => '123.456.789-12',
                'name' => 'Test User 2',
                'data_nascimento' => '2000-01-01',
            ]
        );

        $pessoas = $this->pessoaFisicaRepository->all();

        $this->assertCount(3, $pessoas);
        $this->assertEquals('Test User', $pessoas[0]->nome);
        $this->assertEquals('Test User 1', $pessoas[1]->nome);
        $this->assertEquals('Test User 2', $pessoas[2]->nome);
    }

    public function test_all_method_returns_all_pessoas_fisicas_with_situation_filter(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri01@example.com',
                'cpf' => '123.456.789-11',
                'name' => 'Test User 1',
                'data_nascimento' => '1995-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri02@example.com',
                'cpf' => '123.456.789-12',
                'name' => 'Test User 2',
                'data_nascimento' => '2000-01-01',
                'situacao' => 'inativo',
            ]
        );

        $pessoasAtivas = $this->pessoaFisicaRepository->all(['situacao' => 'ativo']);

        $this->assertCount(2, $pessoasAtivas);
    }

    public function test_all_method_returns_empty_array_when_no_pessoas_fisicas_exist(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri01@example.com',
                'cpf' => '123.456.789-11',
                'name' => 'Test User 1',
                'data_nascimento' => '1995-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri02@example.com',
                'cpf' => '123.456.789-12',
                'name' => 'Test User 2',
                'data_nascimento' => '2000-01-01',
            ]
        );

        $pessoas = $this->pessoaFisicaRepository->all(
            ['situacao' => 'inativo', 'email' => 'testuser@example.com', 'cpf' => '000.000.000-00']
        );

        $this->assertCount(0, $pessoas);
    }

    public function test_all_method_returns_empty_with_name_filter(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri01@example.com',
                'cpf' => '123.456.789-11',
                'name' => 'Test User 1',
                'data_nascimento' => '1995-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri02@example.com',
                'cpf' => '123.456.789-12',
                'name' => 'Test User 2',
                'data_nascimento' => '2000-01-01',
            ]
        );

        $pessoas = $this->pessoaFisicaRepository->all(
            ['nome' => 'Nonexistent Name']
        );

        $this->assertCount(0, $pessoas);
    }

    public function test_all_method_returns_pessoas_fisicas_with_name_filter(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri01@example.com',
                'cpf' => '123.456.789-11',
                'name' => 'Test User 1',
                'data_nascimento' => '1995-01-01',
            ]
        );

        $this->mockPessoaFisica(
            [
                'email' => 'tusuauri02@example.com',
                'cpf' => '123.456.789-12',
                'name' => 'Test User 2',
                'data_nascimento' => '2000-01-01',
            ]
        );

        $pessoas = $this->pessoaFisicaRepository->all(
            ['nome' => 'Test User']
        );

        $this->assertCount(1, $pessoas);
    }

    public function test_method_creates_new_pessoa_fisica(): void
    {
        $user = $this->mockUser();
        $data = [
            'id_usuario' => $user->id,
            'nome' => $user->name,
            'cpf' => '987.654.321-00',
            'data_nascimento' => '1985-05-15',
            'email' => $user->email,
        ];

        $pessoaFisica = $this->pessoaFisicaRepository->create($data);
        $this->assertNotNull($pessoaFisica);
        $this->assertEquals($user->name, $pessoaFisica->nome);
        $this->assertEquals('987.654.321-00', $pessoaFisica->cpf);
    }

    public function test_method_creates_new_pessoa_fisica_with_missing_required_fields(): void
    {
        $data = [
            'nome' => 'Incomplete User'
        ];

        $pessoa = $this->pessoaFisicaRepository->create($data);
        $this->assertNull($pessoa);
    }

    public function test_method_creates_new_pessoa_fisica_with_null_values_in_required_fields(): void
    {
        $user = $this->mockUser();
        $data = [
            'id_usuario' => null,
            'nome' => $user->name,
            'cpf' => null,
            'data_nascimento' => '1985-05-15',
            'email' => $user->email,
        ];

        $pessoa = $this->pessoaFisicaRepository->create($data);
        $this->assertNull($pessoa);
    }

    public function test_method_creates_new_pessoa_fisica_with_empty_data(): void
    {
        $data = [];

        $pessoa = $this->pessoaFisicaRepository->create($data);
        $this->assertNull($pessoa);
    }

    public function test_find_by_id_method_returns_pessoa_fisica_when_exists(): void
    {
        $pessoaFisica = $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $foundPessoaFisica = $this->pessoaFisicaRepository->findById($pessoaFisica->id);
        $this->assertNotNull($foundPessoaFisica);
        $this->assertEquals($pessoaFisica->id, $foundPessoaFisica->id);
    }

    public function test_find_by_id_method_returns_null_when_pessoa_fisica_does_not_exist(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $foundPessoaFisica = $this->pessoaFisicaRepository->findById(9999);
        $this->assertNull($foundPessoaFisica);
    }

    public function test_find_by_id_method_with_invalid_id(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $foundPessoaFisica = $this->pessoaFisicaRepository->findById(-1);
        $this->assertNull($foundPessoaFisica);
    }

    public function test_find_by_uuid_method_with_uuid(): void
    {
        $pessoa = $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $foundPessoaFisica = $this->pessoaFisicaRepository->findByUuid($pessoa->uuid);
        $this->assertNotNull($foundPessoaFisica);
        $this->assertEquals($pessoa->uuid, $foundPessoaFisica->uuid);
    }

    public function test_find_by_uuid_method_with_nonexistent_uuid(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $foundPessoaFisica = $this->pessoaFisicaRepository->findByUuid('nonexistent-uuid');
        $this->assertNull($foundPessoaFisica);
    }

    public function test_find_by_cpf_method(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $foundPessoaFisica = $this->pessoaFisicaRepository->findByCpf('123.456.789-10');
        $this->assertNotNull($foundPessoaFisica);
        $this->assertEquals('123.456.789-10', $foundPessoaFisica->cpf);
    }

    public function test_find_by_cpf_method_with_nonexistent_cpf(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $foundPessoaFisica = $this->pessoaFisicaRepository->findByCpf('nonexistent-cpf');
        $this->assertNull($foundPessoaFisica);
    }

    public function test_find_by_email_method(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );

        $foundPessoaFisica = $this->pessoaFisicaRepository->findByEmail('testuser@example.com');

        $this->assertNotNull($foundPessoaFisica);
        $this->assertEquals('testuser@example.com', $foundPessoaFisica->email);
    }

    public function test_find_by_email_method_with_nonexistent_email(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $foundPessoaFisica = $this->pessoaFisicaRepository->findByEmail('nonexistent@example.com');
        $this->assertNull($foundPessoaFisica);
    }

    public function test_update_method_updates_existing_pessoa_fisica(): void
    {
        $pessoaFisica = $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $updateData = [
            'nome' => 'Updated User',
            'cpf' => '987.654.321-00',
        ];
        $updatedPessoaFisica = $this->pessoaFisicaRepository->update($pessoaFisica->id, $updateData);
        $this->assertNotNull($updatedPessoaFisica);
        $this->assertEquals('Updated User', $updatedPessoaFisica->nome);
        $this->assertEquals('987.654.321-00', $updatedPessoaFisica->cpf);
    }

    public function test_update_method_with_empty_data(): void
    {
        $pessoaFisica = $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );

        $updatedPessoaFisica = $this->pessoaFisicaRepository->update($pessoaFisica->id, []);
        $this->assertNull($updatedPessoaFisica);
    }

    public function test_update_method_with_nonexistent_id(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $updatedPessoaFisica = $this->pessoaFisicaRepository->update(9999, [
            'nome' => 'Updated User',
        ]);
        $this->assertNull($updatedPessoaFisica);
    }

    public function test_delete_method_with_invalid_id(): void
    {
        $pessoaFisica = $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $result = $this->pessoaFisicaRepository->delete(-1);
        $this->assertFalse($result);
    }

    public function test_delete_method_pessoa_fisica(): void
    {
        $pessoaFisica = $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $result = $this->pessoaFisicaRepository->delete($pessoaFisica->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('pessoa_fisica', [
            'id' => $pessoaFisica->id,
        ]);
    }

    public function test_delete_method_with_nonexistent_id(): void
    {
        $this->mockPessoaFisica(
            [
                'email' => 'testuser@example.com',
                'cpf' => '123.456.789-10',
                'name' => 'Test User',
                'data_nascimento' => '1991-01-01',
            ]
        );
        $result = $this->pessoaFisicaRepository->delete(9999);
        $this->assertFalse($result);
    }
}
