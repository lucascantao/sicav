<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;


class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Unidade::create([            
            'nome' => 'SEDE LOMAS'
        ]);

        Unidade::create([            
            'nome' => 'BOSQUE'
        ]);
        
        Unidade::create([            
            'nome' => 'CASA VICENTE'
        ]);

        Unidade::create([            
            'nome' => 'NURE ALTAMIRA'
        ]);

        Unidade::create([            
            'nome' => 'NURE REDENÇÃO'
        ]);

        Unidade::create([            
            'nome' => 'NURE SANTARÉM'
        ]);

        Unidade::create([            
            'nome' => 'NURE PARAGOMINAS'
        ]);

        Unidade::create([            
            'nome' => 'NURE MARABÁ'
        ]);

        Unidade::create([            
            'nome' => 'NURE ITAITUBA'
        ]);
    
    }
}
