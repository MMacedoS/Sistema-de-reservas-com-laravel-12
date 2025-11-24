<?php

namespace App\Repositories\Contracts;

interface IUserRepository
{
    public function findByUuid(string $uuid);
    public function findById(int $id);
    public function findByEmail(string $email);
    public function all(array $filters = []);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
