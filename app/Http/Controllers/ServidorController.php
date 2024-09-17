<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servidor;
use Illuminate\Support\Facades\DB;

class ServidorController extends Controller
{

    public function getServidores(Request $request) {

        $data = $request->all();
        $query = Servidor::query();
        $nome = isset($data['servidor_nome']) ? $data['servidor_nome'] : null;
        $setor_id = '';
        if(isset($data['setor_id'])) {
            $setor_id = $data['setor_id'];
            $query->where('setor_id', '=' , $setor_id);
        } else if(isset($nome)) {
            $setor_id = DB::table('servidores')->where('nome', '=', $nome)->first()->setor_id;
            $query->where('setor_id', '=' , $setor_id);
        }


        $query->where('status', '=', 'Ativo');

        $servidores = $query->orderBy('nome', 'asc')->get();

        return [
            'view' => view('visitas.servidores' , ['servidores'=>$servidores, 'servidor_nome' => $nome ])->render(),
            'setor_id' => $setor_id
        ];
    }

    public function updateServidores() {
        $url = env('LDAP_API_URL');

        $_retorno = $this->do_get($url);

        if($_retorno['success']) {
            $usuarios = $_retorno['dados'];
            $a = [];

            foreach($usuarios as $usuario) {

                // $sigla = $usuario['setor'];

                // if(!empty($sigla)) {
                //     $obj = DB::table('setores')->where('sigla', $sigla)->first();
                //     if(!isset($obj)){
                //         $a[$sigla] = $sigla;
                //     }
                // }

                Servidor::updateOrCreate(
                    ['usuario_rede' => $usuario['login']],
                    [
                        'status' => ($usuario['active'] == 1) ? 'Ativo' : 'Inativo',
                        'nome' => $usuario['name'],
                        'usuario_rede' => $usuario['login'],
                        'setor_id' => isset($obj->id) ? $obj->id : null
                    ]
                );
            }
        }
    }
}
