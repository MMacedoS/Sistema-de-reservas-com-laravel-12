<?php

namespace Tests\Feature\Repositories\Person;

use Tests\TestCase;

class PessoaFisicaRepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_all_method_returns_all_pessoas_fisicas(): void
    {
        $pessoa_fisica = $this->mockPessoaFisica();
        dd($pessoa_fisica);
        $this->assertTrue(true);
    }
}
