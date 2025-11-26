<?php

namespace Database\Factories\Person;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person\PessoaFisica>
 */
class PessoaFisicaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_usuario' => 1,
            'nome' => $this->faker->name(),
            'nome_social' => $this->faker->firstName(),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'data_nascimento' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefone' => $this->faker->phoneNumber(),
            'endereco' => $this->faker->address(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->state(),
            'cep' => $this->faker->postcode(),
            'genero' => $this->faker->randomElement(['Masculino', 'Feminino', 'Outro']),
            'estado_civil' => $this->faker->randomElement(['Solteiro', 'Casado', 'Divorciado', 'Viúvo']),
            'profissao' => $this->faker->jobTitle(),
            'situacao' => $this->faker->randomElement(['Ativo', 'Inativo']),
        ];
    }
}
