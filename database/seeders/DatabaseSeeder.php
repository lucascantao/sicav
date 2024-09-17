<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setor;
use App\Models\Perfil;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PerfilSeeder::class,
            SetorSeeder::class,
            UserSeeder::class,
            UnidadeSeeder::class,
            VersaoSeeder::class,
            ServidorSeeder::class
        ]);

    }
}
