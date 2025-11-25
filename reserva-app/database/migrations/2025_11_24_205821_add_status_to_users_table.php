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
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable(false);
                $table->string('email')->unique();
                $table->string('password');
                $table->enum('role', ['recepcionista', 'admin', 'gerente', 'garcom'])->default('recepcionista');
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
            return;
        }

        if (env('DB_CONNECTION') != 'testing_memory') {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (env('DB_CONNECTION') != 'testing_memory') {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
