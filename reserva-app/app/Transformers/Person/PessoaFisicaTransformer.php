<?php

namespace App\Transformers\Person;

use App\Models\Person\PessoaFisica;
use Illuminate\Support\Collection;

class PessoaFisicaTransformer
{
    public function transform(PessoaFisica $pessoaFisica)
    {
        return [
            'id' => $pessoaFisica->uuid,
            'code' => $pessoaFisica->id,
            'name' => $pessoaFisica->nome,
            'social_name' => $pessoaFisica->nome_social,
            'cpf' => $pessoaFisica->cpf,
            'birth_date' => $pessoaFisica->data_nascimento,
            'email' => $pessoaFisica->email,
            'phone' => $pessoaFisica->telefone,
            'address' => $pessoaFisica->endereco,
            'city' => $pessoaFisica->cidade,
            'state' => $pessoaFisica->estado,
            'zip_code' => $pessoaFisica->cep,
            'gender' => $pessoaFisica->genero,
            'marital_status' => $pessoaFisica->estado_civil,
            'profession' => $pessoaFisica->profissao,
            'status' => $pessoaFisica->situacao,
            'created_at' => $pessoaFisica->created_at,
            'updated_at' => $pessoaFisica->updated_at,
        ];
    }

    public function transformCollection(Collection $pessoasFisicas)
    {
        if ($pessoasFisicas->isEmpty()) {
            return [];
        }
        return array_values($pessoasFisicas->map([$this, 'transform'])->toArray());
    }
}
