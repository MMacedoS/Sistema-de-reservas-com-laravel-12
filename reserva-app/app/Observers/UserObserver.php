<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->uuid = (string) Str::uuid();
    }

    public function created(User $user): void
    {
        //
    }

    public function updating(User $user): void
    {
        //
    }

    public function updated(User $user): void
    {
        //
    }

    public function deleting(User $user): void
    {
        //
    }

    public function deleted(User $user): void
    {
        //
    }
}
