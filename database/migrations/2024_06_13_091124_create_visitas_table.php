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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->string('numero_cracha')->nullable();
            $table->string('servidor')->nullable();

            //$table->bigInteger('pessoa_id')->unsigned()->nullable();
            //$table->foreign('pessoa_id')->references('id')->on('pessoas');
            $table->foreignId('pessoa_id')->constrained('pessoas');

            $table->bigInteger('setor_id')->unsigned()->nullable();
            $table->foreign('setor_id')->references('id')->on('setores');
            $table->bigInteger('usuario_cadastro_id')->unsigned()->nullable();
            $table->foreign('usuario_cadastro_id')->references('id')->on('users');
            $table->bigInteger('empresa_id')->unsigned()->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->bigInteger('unidade_id')->unsigned()->nullable();
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};
