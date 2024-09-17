<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Versao;

class VersaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Versao::create([
            'versao' => '1.0.0',
            'data' => date("Y-m-d"),
            'descricao' => 'primeira versao do sistema'
        ]);
    }
}
