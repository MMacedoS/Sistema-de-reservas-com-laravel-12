<?php

namespace App\Transformers;

use App\Models\User;
use Illuminate\Support\Collection;

class UserTransformer
{
    public function transform(User $user)
    {
        return [
            'code' => $user->id,
            'id' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }

    public function transformCollection(Collection $users)
    {
        if ($users->isEmpty()) {
            return [];
        }
        return array_map([$this, 'transform'], $users->toArray());
    }
}
