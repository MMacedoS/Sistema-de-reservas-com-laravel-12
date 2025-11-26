<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (env('DB_CONNECTION') == 'testing_memory') {
            Schema::create('pessoa_fisica', function (Blueprint $table) {
                $table->increments('id');
                $table->uuid('uuid')->unique();
                $table->unsignedInteger('id_usuario');
                $table->string('nome');
                $table->string('nome_social')->nullable();
                $table->string('cpf')->unique();
                $table->date('data_nascimento');
                $table->string('email')->unique();
                $table->string('telefone')->nullable();
                $table->string('endereco')->nullable();
                $table->string('cidade')->nullable();
                $table->string('estado')->nullable();
                $table->string('cep')->nullable();
                $table->string('genero')->nullable();
                $table->string('estado_civil')->nullable();
                $table->string('profissao')->nullable();
                $table->enum('situacao', ['ativo', 'inativo'])->default('ativo');
                $table->timestamps();
            });

            Schema::table('pessoa_fisica', function (Blueprint $table) {
                $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            });
            return;
        }

        if (env('DB_CONNECTION') != 'testing_memory') {
            Schema::create('pessoa_fisica', function (Blueprint $table) {
                $table->increments('id');
                $table->uuid('uuid')->unique();
                $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
                $table->string('nome');
                $table->string('nome_social')->nullable();
                $table->string('cpf')->unique();
                $table->date('data_nascimento');
                $table->string('email')->unique();
                $table->string('telefone')->nullable();
                $table->string('endereco')->nullable();
                $table->string('cidade')->nullable();
                $table->string('estado')->nullable();
                $table->string('cep')->nullable();
                $table->string('genero')->nullable();
                $table->string('estado_civil')->nullable();
                $table->string('profissao')->nullable();
                $table->enum('situacao', ['ativo', 'inativo'])->default('ativo');
                $table->timestamps();
            });

            Schema::table('pessoa_fisica', function (Blueprint $table) {
                $table->index('uuid');
                $table->index('cpf');
                $table->index('email');
                $table->index('situacao');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (env('DB_CONNECTION') != 'testing_memory') {
            Schema::dropIfExists('pessoa_fisica');
            return;
        }
    }
};
