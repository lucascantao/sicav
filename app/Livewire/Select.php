<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Servidor;
use App\Models\Setor;
use Illuminate\Support\Facades\DB;

class Select extends Component
{

    public $servidores;
    public $setores;
    public $setor_id;
    public $servidor_id;

    public function mount()
    {
        $this->servidores = Servidor::all();
        $this->setores = Setor::all();
        $this->setor_id = "";
        $this->servidor_id = "";
    }

    public function render()
    {
        return view('livewire.select');
    }

    public function setServidores() {
        echo $this->setor_id;
    }

    public function updateServidores() {
        $this->servidores = Servidor::where('setor_id', $this->setor_id)->get();
    }
}
