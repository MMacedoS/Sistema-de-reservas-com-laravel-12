<?php

namespace App\Repositories\Entities\Person;

use App\Models\Person\PessoaFisica;
use App\Repositories\Contracts\Person\IPessoaFisicaRepository;
use App\Traits\ServiceTrait;
use App\Traits\SingletonTrait;

class PessoaFisicaRepository implements IPessoaFisicaRepository
{
    use ServiceTrait, SingletonTrait;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->model = new PessoaFisica();
    }

    public function findByCpf(string $cpf)
    {
        if (is_null($cpf)) {
            return null;
        }

        $pessoaFisica = $this->model->whereCpf($cpf)->first();
        return $pessoaFisica;
    }

    public function findByEmail(string $email)
    {
        if (is_null($email)) {
            return null;
        }

        $pessoaFisica = $this->model->whereEmail($email)->first();
        return $pessoaFisica;
    }

    public function all(array $criteria = [], array $orders = [], array $orWheres = [])
    {
        if (empty($criteria) && empty($orders) && empty($orWheres)) {
            return $this->model->all();
        }
        $pessoasFisicas = $this->model->select();

        $pessoasFisicas = $this->applyCriteria($pessoasFisicas, $criteria, $orWheres);
        $pessoasFisicas = $this->applyOrders($pessoasFisicas, $orders);
        return $pessoasFisicas->get();
    }

    public function create(array $data)
    {
        if (empty($data)) {
            return null;
        }

        try {
            $pessoaFisica = $this->model->create($data);
            return $pessoaFisica;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function update(int $id, array $data)
    {
        if (empty($data)) {
            return null;
        }

        $data = (object) $data;

        $pessoaFisica = $this->findById($id);
        if (is_null($pessoaFisica)) {
            return null;
        }

        try {
            if (isset($data->nome)) {
                $pessoaFisica->nome = $data->nome;
            }

            if (isset($data->cpf)) {
                $pessoaFisica->cpf = $data->cpf;
            }

            if (isset($data->data_nascimento)) {
                $pessoaFisica->data_nascimento = $data->data_nascimento;
            }

            if (isset($data->email)) {
                $pessoaFisica->email = $data->email;
            }

            if (isset($data->telefone)) {
                $pessoaFisica->telefone = $data->telefone;
            }

            if (isset($data->endereco)) {
                $pessoaFisica->endereco = $data->endereco;
            }

            if (isset($data->cidade)) {
                $pessoaFisica->cidade = $data->cidade;
            }

            if (isset($data->estado)) {
                $pessoaFisica->estado = $data->estado;
            }

            if (isset($data->cep)) {
                $pessoaFisica->cep = $data->cep;
            }

            if (isset($data->genero)) {
                $pessoaFisica->genero = $data->genero;
            }

            if (isset($data->estado_civil)) {
                $pessoaFisica->estado_civil = $data->estado_civil;
            }

            if (isset($data->profissao)) {
                $pessoaFisica->profissao = $data->profissao;
            }

            if (isset($data->situacao)) {
                $pessoaFisica->situacao = $data->situacao;
            }
            $pessoaFisica->save();
            return $pessoaFisica;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function delete(int $id)
    {
        if (is_null($id)) {
            return false;
        }

        $pessoaFisica = $this->findById($id);

        if (is_null($pessoaFisica)) {
            return false;
        }

        try {
            $pessoaFisica->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
