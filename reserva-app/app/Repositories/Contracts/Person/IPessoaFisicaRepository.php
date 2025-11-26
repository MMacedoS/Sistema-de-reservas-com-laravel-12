<?php

namespace App\Repositories\Contracts\Person;

interface IPessoaFisicaRepository
{
    public function findByCpf(string $cpf);
    public function findByEmail(string $email);
    public function findByUuid(string $uuid);
    public function all(array $criteria = [], array $orders = [], array $orWheres = []);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
