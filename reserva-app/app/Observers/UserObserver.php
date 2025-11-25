<?php

namespace App\Observers;

use App\Models\User;
use App\Traits\ValidateRequiredFieldsTrait;
use Illuminate\Support\Str;

class UserObserver
{
    use ValidateRequiredFieldsTrait;

    public function creating(User $user)
    {
        if (!$this->validateToSaveUpdate($user)) {
            return null;
        }
    }

    public function created(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        if (!$this->validateToSaveUpdate($user)) {
            return null;
        }
    }

    public function updated(User $user)
    {
        //
    }

    public function saving(User $user)
    {
        //
    }

    public function saved(User $user)
    {
        //
    }

    public function deleting(User $user)
    {
        //
    }

    public function deleted(User $user)
    {
        //
    }

    private function validateToSaveUpdate($model)
    {
        if (!$this->hasRequiredAttributes($model)) {
            return false;
        }

        if ($this->hasNullValueAttributes($model)) {
            return false;
        }

        return true;
    }

    private function hasRequiredAttributes(User $model): bool
    {
        return $this
            ->hasRequiredModelAttributes(
                $model,
                [
                    'name',
                    'email',
                    'password',
                    'role'
                ]
            );
    }

    private function hasNullValueAttributes(User $model): bool
    {
        return $this
            ->hasNullValueModelAttributes(
                $model,
                [
                    'name',
                    'email',
                    'password',
                ]
            );
    }
}
