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
        Schema::create('servidores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('status', ['Ativo', 'Inativo']);
            $table->string('usuario_rede');
            $table->bigInteger('setor_id')->unsigned()->nullable();
            $table->foreign('setor_id')->references('id')->on('setores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servidores');
    }
};
