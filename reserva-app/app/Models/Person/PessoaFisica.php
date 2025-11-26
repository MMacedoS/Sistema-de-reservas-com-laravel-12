<?php

namespace App\Models\Person;

use App\Models\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaFisica extends Model
{
    use HasUuid, HasFactory;

    protected $table = 'pessoa_fisica';

    protected $fillable = [
        'uuid',
        'id_usuario',
        'nome',
        'nome_social',
        'cpf',
        'data_nascimento',
        'email',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'genero',
        'estado_civil',
        'profissao',
        'situacao',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
