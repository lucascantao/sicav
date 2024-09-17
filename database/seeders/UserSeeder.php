<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'José Lucas dos Santos Cantão',
            'username' => 'jose.cantao',
            'setor_id' => 32,
            'perfil_id' => 3,

        ]);
        User::create([
            'name' => 'Bruno Gomes Haick',
            'username' => 'bruno.haick',
            'setor_id' => 32,
            'perfil_id' => 3,

        ]);
        User::create([
            'name' => 'Demys Alves Brito',
            'username' => 'demys.brito',
            'setor_id' => 32,
            'perfil_id' => 3,

        ]);
        User::create([
            'name' => 'Atahualpa Fagundes de Souza Assis',
            'username' => 'atahualpa.assis',
            'setor_id' => 32,
            'perfil_id' => 3,
            
        ]);
        User::create([
            'name' => 'Hugo Mendes Tavares Neto',
            'username' => 'hugo.neto',
            'setor_id' => 32,
            'perfil_id' => 3,

        ]);
        
    }
}
