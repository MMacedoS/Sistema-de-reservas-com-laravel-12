<?php

namespace App\Repositories\Entities;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use App\Traits\ServiceTrait;
use App\Traits\SingletonTrait;

class UserRepository implements IUserRepository
{
    use ServiceTrait, SingletonTrait;

    public function __construct()
    {
        $this->model = new User();
    }

    public function findByEmail(string $email)
    {
        if (is_null($email)) {
            return null;
        }

        $user = $this->model->where('email', $email)->first();
        return $user;
    }

    public function all(array $filters = [])
    {
        $users = $this->model->select();

        $users->where(function ($query) use ($filters) {
            if (isset($filters['name'])) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            }
            if (isset($filters['email'])) {
                $query->where('email', 'like', '%' . $filters['email'] . '%');
            }
        });

        return $users->get();
    }

    public function create(array $data)
    {
        if (empty($data)) {
            return null;
        }

        try {
            $user = $this->model->create($data);
            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function update(int $id, array $data)
    {
        if (is_null($id) || empty($data)) {
            return null;
        }

        $user = $this->findById($id);

        if (!$user) {
            return null;
        }

        try {
            if (isset($data['name']) && !empty($data['name'])) {
                $user->name = $data['name'];
            }

            if (isset($data['email']) && !empty($data['email'])) {
                $user->email = $data['email'];
            }

            if (isset($data['password']) && !empty($data['password'])) {
                $user->password = $data['password'];
            }

            if (isset($data['role']) && !empty($data['role'])) {
                $user->role = $data['role'];
            }

            if (isset($data['status']) && !empty($data['status'])) {
                $user->status = $data['status'];
            }

            if ($user->isDirty()) {
                $user->save();
            }

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function delete(int $uuid)
    {
        if (is_null($uuid)) {
            return false;
        }

        $user = $this->findById($uuid);

        if (!$user) {
            return false;
        }

        try {
            $user->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
