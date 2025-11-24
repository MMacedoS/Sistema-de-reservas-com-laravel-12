<?php

namespace App\Repositories\Entities;

use App\Repositories\Contracts\IUserRepository;

class UserRepository implements IUserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function findByUuid(string $uuid) {}

    public function findById(int $id) {}

    public function findByEmail(string $email) {}

    public function all() {}

    public function create(array $data) {}

    public function update(string $uuid, array $data) {}

    public function delete(string $uuid) {}
}
