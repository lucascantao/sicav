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
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('documento')->unique();
            $table->enum('tipo_documento', ['CPF', 'Passaporte']);
            $table->string('email')->nullable();
            $table->enum('sexo', ['Masculino', 'Feminino']);
            $table->date('data_nascimento')->nullable();
            $table->string('telefone1');
            $table->string('telefone2')->nullable();
            $table->string('foto1')->nullable();
            $table->string('foto2')->nullable();
            $table->bigInteger('usuario_cadastro_id')->unsigned()->nullable();
            $table->foreign('usuario_cadastro_id')->references('id')->on('users');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas');
    }
};
