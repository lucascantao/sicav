<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Perfil;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Perfil::create([
            'nome' => 'Agente Portaria',
            //'descricao' => 'Usuario comum'
        ]);
        Perfil::create([
            'nome' => 'Auditor',
            //'descricao' => 'Administrador do setor'
        ]);
        Perfil::create([
            'nome' => 'Master',
            //'descricao' => 'Mestre do sistema'
        ]);
    }
}
