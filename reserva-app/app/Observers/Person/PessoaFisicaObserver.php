<?php

namespace App\Observers\Person;

use App\Models\Person\PessoaFisica;
use App\Traits\ValidateRequiredFieldsTrait;

class PessoaFisicaObserver
{
    use ValidateRequiredFieldsTrait;

    public function creating(PessoaFisica $pessoaFisica)
    {
        if (!$this->validateToSaveUpdate($pessoaFisica)) {
            return null;
        }
    }

    /**
     * Handle the PessoaFisica "created" event.
     */
    public function created(PessoaFisica $pessoaFisica): void
    {
        //
    }

    public function updating(PessoaFisica $pessoaFisica)
    {
        if (!$this->validateToSaveUpdate($pessoaFisica)) {
            return null;
        }
    }

    /**
     * Handle the PessoaFisica "updated" event.
     */
    public function updated(PessoaFisica $pessoaFisica): void
    {
        //
    }

    public function saving(PessoaFisica $pessoaFisica)
    {
        if (!$this->validateToSaveUpdate($pessoaFisica)) {
            return null;
        }
    }

    public function saved(PessoaFisica $pessoaFisica)
    {
        //
    }

    public function deleting(PessoaFisica $pessoaFisica)
    {
        if (!empty($pessoaFisica->usuario())) {
            $pessoaFisica->usuario()->delete();
        }
    }

    /**
     * Handle the PessoaFisica "deleted" event.
     */
    public function deleted(PessoaFisica $pessoaFisica): void
    {
        //
    }

    /**
     * Handle the PessoaFisica "restored" event.
     */
    public function restored(PessoaFisica $pessoaFisica): void
    {
        //
    }

    /**
     * Handle the PessoaFisica "force deleted" event.
     */
    public function forceDeleted(PessoaFisica $pessoaFisica): void
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

    private function hasRequiredAttributes(PessoaFisica $model): bool
    {
        return $this
            ->hasRequiredModelAttributes(
                $model,
                [
                    'id_usuario',
                    'nome',
                    'cpf',
                    'data_nascimento',
                    'email',
                ]
            );
    }

    private function hasNullValueAttributes(PessoaFisica $model): bool
    {
        return $this
            ->hasNullValueModelAttributes(
                $model,
                [
                    'name',
                    'email',
                    'telefone',
                ]
            );
    }
}
