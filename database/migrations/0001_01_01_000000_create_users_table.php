<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('login')->unique();
            $table->string('password');
            $table->string('situacao')->default('ativo');
            $table->timestamps();
        });

        // ❌ REMOVE ISSO se não for usar recuperação de senha
        // pois depende de email
        /*
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('login')->primary(); // se quiser adaptar
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        */

        // ✅ sessões (ok manter)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        // Schema::dropIfExists('password_reset_tokens'); // removido
        Schema::dropIfExists('users');
    }
};