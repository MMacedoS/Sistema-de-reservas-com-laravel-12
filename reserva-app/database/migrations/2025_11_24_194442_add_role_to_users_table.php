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
            // recriado em outras migrations
            return;
        }

        if (env('DB_CONNECTION') != 'testing_memory') {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['recepcionista', 'admin', 'gerente', 'garcom'])->nullable()->default('recepcionista')->after('email');
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
                $table->dropColumn('role');
            });
        }
    }
};
