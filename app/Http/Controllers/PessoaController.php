<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use DateTime;
class PessoaController extends Controller
{
    public function index() {
        $pessoas = Pessoa::orderBy('nome', 'asc')->get();
        return view('pessoas.index', ['pessoas' => $pessoas]);
    }

    public function create() {
        $id_usuario = Auth::user()->id;
        return view('pessoas.create', ['id_usuario' => $id_usuario]);
    }

    public function edit(Pessoa $pessoa) {
        return view('pessoas.edit', ['pessoa' => $pessoa]);
    }

    private function validacaoFormVisitante($tipo_documento, $documento, $telefone1, $telefone2 = null) {
        if ($tipo_documento  == 'CPF') {
            if (!$this->validaCPF($documento)) {
                return ['error' => 'Número de CPF inválido'];
            }
        }

        if (!$this->validaCelular($telefone1)) {
            return ['error' => 'Número de Celuar inválido'];
        }

        if (!empty($telefone2)) {
            if (!$this->validaTelefone($telefone2)) {
                return ['error' => 'Número de Telefone inválido'];
            }
        } else {
            return false;
        }
    }

    public function store(Request $request) {
        $data = $request->all();

        $messages = [
            'documento.unique' => 'O documento já está em uso.',
            'foto1.required' => 'O campo Foto 1 é obrigatório',
            'foto2.required' => 'O campo Foto 2 é obrigatório'
        ];

        // Validação
        $request->validate([
            'documento' => 'required|string|unique:pessoas,documento',
            'foto1' => 'required',
            'foto2' => 'required'
        ], $messages);

        $var = $this->validacaoFormVisitante($data['tipo_documento'], $data['documento'], $data['telefone1'], $data['telefone2']);

        if ($var) {
            return redirect()->back()->withInput()->withErrors($var);
        }

        // Processamento das imagens
        $imagem1_parts = explode(";base64,", $request->input('foto1'));
        $imagem2_parts = explode(";base64,", $request->input('foto2'));

        if (count($imagem1_parts) > 1) {
            $imagem1_base64 = base64_decode($imagem1_parts[1]);
            $nome_imagem1 = $request['documento'] . '_1.jpg'; // Nome único para a imagem
            $caminho_imagem1 = 'images/fotos/' . $nome_imagem1;
            file_put_contents(public_path($caminho_imagem1), $imagem1_base64);
        } else {
            return "Erro ao capturar a imagem 1. Verifique se a captura da webcam foi feita corretamente.";
        }

        if (count($imagem2_parts) > 1) {
            $imagem2_base64 = base64_decode($imagem2_parts[1]);
            $nome_imagem2 = $request['documento'] . '_2.jpg'; // Nome único para a imagem
            $caminho_imagem2 = 'images/fotos/' . $nome_imagem2;
            file_put_contents(public_path($caminho_imagem2), $imagem2_base64);
        } else {
            return "Erro ao capturar a imagem 2. Verifique se a captura da webcam foi feita corretamente.";
        }

        // Criação do registro no banco de dados

        try {
            $novaPessoa = Pessoa::create([
                'nome' => mb_strtoupper($request['nome'], "utf-8"),
                'documento' => $request['documento'],
                'tipo_documento' => $request['tipo_documento'],
                'email' => $request['email'],
                'sexo' => $request['sexo'],
                'data_nascimento' => $request['data_nascimento'],
                'telefone1' => $request['telefone1'],
                'telefone2' => $request['telefone2'],
                'foto1' => $caminho_imagem1,
                'foto2' => $caminho_imagem2,
                'usuario_cadastro_id' => $request['usuario_cadastro_id']
            ]);

            return redirect()->route('pessoa.show', ['pessoa' => $novaPessoa])->with('success', 'Visitante criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao criar o visitante.']);
        }
    }

    public function show(Pessoa $pessoa) {
        $pessoa = Pessoa::find($pessoa->id);
        $pessoa->data_nascimento = isset($pessoa->data_nascimento) ? date_format(date_create_from_format('Y-m-d', $pessoa['data_nascimento']), 'd/m/Y') : null;
        return view('pessoas.show', compact('pessoa'));
    }

    public function update($id_pessoa, Request $request) {
        $pessoa = Pessoa::find($id_pessoa);

        $data = $request->all();

        // Mensagens de validação
        $messages = [
            'documento.unique' => 'O documento já está em uso.',
            'foto1.required' => 'O campo Foto1 é obrigatório',
            'foto2.required' => 'O campo Foto1 é obrigatório'
        ];

        if($pessoa->documento != $request['documento']){
            $request->validate([
                'documento' => 'required|string|unique:pessoas,documento',
                'foto1' => 'required',
                'foto2' => 'required'
            ], $messages);

            $novo_caminho_imagem1 = 'images/fotos/' . $request['documento'] . '_1.jpg'; // Nome único para a imagem;
            rename(public_path($pessoa->foto1),  $novo_caminho_imagem1);
            $pessoa->foto1 = $novo_caminho_imagem1;

            $novo_caminho_imagem2 = 'images/fotos/' . $request['documento'] . '_2.jpg'; // Nome único para a imagem;
            rename(public_path($pessoa->foto2),  $novo_caminho_imagem2);
            $pessoa->foto2 = $novo_caminho_imagem2;
        }

        print_r($data);

        $var = $this->validacaoFormVisitante($data['tipo_documento'], $data['documento'], $data['telefone1'], $data['telefone2']);

        if ($var) {
            return redirect()->back()->withInput()->withErrors($var);
        }

        // Processamento das imagens
        $imagem1_parts = explode(";base64,", $request->input('foto1'));
        $imagem2_parts = explode(";base64,", $request->input('foto2'));

        if (count($imagem1_parts) > 1) {
            $imagem1_base64 = base64_decode($imagem1_parts[1]);
            $nome_imagem1 = $request['documento'] . '_1.jpg'; // Nome único para a imagem
            $caminho_imagem1 = 'images/fotos/' . $nome_imagem1;
            file_put_contents(public_path($caminho_imagem1), $imagem1_base64);
        } else {
            $caminho_imagem1=$pessoa->foto1;
        }

        if (count($imagem2_parts) > 1) {
            $imagem2_base64 = base64_decode($imagem2_parts[1]);
            $nome_imagem2 = $request['documento'] . '_2.jpg'; // Nome único para a imagem
            $caminho_imagem2 = 'images/fotos/' . $nome_imagem2;
            file_put_contents(public_path($caminho_imagem2), $imagem2_base64);
        } else {
            $caminho_imagem2=$pessoa->foto2;
        }

        // Atualização dos dados da pessoa
        $pessoa->update([
            'nome' => mb_strtoupper($request['nome'], "utf-8"),
            'documento' => $request['documento'],
            'tipo_documento' => $request['tipo_documento'],
            'email' => $request['email'],
            'sexo' => $request['sexo'],
            'data_nascimento' => $request['data_nascimento'],
            'telefone1' => $request['telefone1'],
            'telefone2' => $request['telefone2'],
            'foto1' => $caminho_imagem1,
            'foto2' => $caminho_imagem2,
            'usuario_cadastro_id' => Auth::user()->id
        ]);

        return redirect(route('pessoa.index'))->with('success', 'Visitante editado com sucesso!');
    }

    public function softDelete($id_pessoa){
        $pessoa = Pessoa::find($id_pessoa);
        $currentDateTime = Carbon::now()->toDateTimeString();
        $pessoa->deleted_at = $currentDateTime;
        //$pessoa->deleted_by = Auth::user()->id;
        $pessoa->save();

        return redirect(route('pessoa.index'))->with('success', 'Visitante desativado com sucesso!');
    }

    public function enable($id_pessoa) {
        $pessoa = Pessoa::find($id_pessoa);
        $pessoa->deleted_at = null;
        //$pessoa->deleted_by = null;
        $pessoa->save();

        return redirect(route('pessoa.index'))->with('success','Visitante habilitado com sucesso!');
    }

    public function destroy($id) {

        if(User::where('pessoa_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('pessoa.index'))->with('failed', 'Não é possível excluir o Visitante, pois existem registros que a usam');
        }

        if(Registro::where('pessoa_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('pessoa.index'))->with('failed', 'Não é possível excluir o Visitante, pois existem registros que a usam');
        }

        $pessoa = Pessoa::find($id);
        $pessoa->delete();
        return redirect(route('pessoa.index'))->with('success', 'Visitante excluído com sucesso!');
    }

    public function gerarRelatorio(Request $request)
    {
        $pessoas = DB::table('pessoas')
            ->select(
                'pessoas.id',
                'pessoas.nome',
                'pessoas.tipo_documento',
                DB::raw("REPLACE(REPLACE(pessoas.documento, '.', ''), '-', '') as documento_hidden"),
                'pessoas.documento',
                'pessoas.data_nascimento',
                DB::raw("DATE_FORMAT(pessoas.data_nascimento, '%d/%m/%Y') as data_nascimento_formatada"),
                'pessoas.telefone1',
                DB::raw("IF(pessoas.deleted_at IS NULL, 'Ativo', 'Inativo') as status")
            );

        if ($request->has('nome') && $request->nome) {
            $pessoas->where('pessoas.nome', 'like', "%{$request->nome}%");
        }

        if ($request->has('tipo_documento') && $request->tipo_documento) {
            $pessoas->where('pessoas.tipo_documento', "{$request->tipo_documento}");
        }

        if ($request->has('numero_documento') && $request->numero_documento) {
            $pessoas->where('pessoas.documento', 'like', "%{$request->numero_documento}%");
        }

        if ($request->has('data_nascimento') && $request->data_nascimento) {
            $pessoas->where('pessoas.data_nascimento', $request->data_nascimento);
        }

        if ($request->has('ordem') && $request->ordem) {
            $ordemArr = $request->ordem;
            $colunas_arr = [
                0 => 'nome',
                1 => 'tipo_documento',
                3 => 'documento',
                4 => 'data_nascimento',
                5 => 'telefone1'
            ];

            foreach($ordemArr as $ordem) {
                $key = $ordem[0];
                $direction = strtolower($ordem[1]) == 'desc' ? 'desc' : 'asc';
                if (isset($colunas_arr[$key])) {
                    $pessoas->orderBy($colunas_arr[$key], $direction);
                }
            }
        }

        $sql = $pessoas->toSql();
        $bindings = $pessoas->getBindings();

        // Substituir os bindings na query para visualização
        foreach ($bindings as $binding) {
           $binding = is_numeric($binding) ? $binding : "'$binding'";
           $sql = preg_replace('/\?/', $binding, $sql, 1);
        }
        Log::info('Query gerada: ' . $sql);

        $pessoas = $pessoas->get();

        return view('pessoas.relatorio', ['pessoas' => $pessoas]);

    }

    public function getPessoasTable(Request $request) {

        $pessoas = DB::table('pessoas')
            ->select(
                'pessoas.id',
                'pessoas.nome',
                'pessoas.tipo_documento',
                'pessoas.documento',
                'pessoas.data_nascimento',
                DB::raw("DATE_FORMAT(pessoas.data_nascimento, '%d/%m/%Y') as data_nascimento_formatada"),
                'pessoas.telefone1',
                DB::raw("IF(pessoas.deleted_at IS NULL, 'Ativo', 'Inativo') as status")
            );

        if ($request->has('nome') && $request->nome) {
            $pessoas->where('pessoas.nome', 'like', "%{$request->nome}%");
        }

        if ($request->has('tipo_documento') && $request->tipo_documento) {
            $pessoas->where('pessoas.tipo_documento', "{$request->tipo_documento}");
        }

        if ($request->has('numero_documento') && $request->numero_documento) {
            if(!($request->has('tipo_documento') && $request->tipo_documento)){
                $pessoas->whereRaw("REPLACE(REPLACE(pessoas.documento, '.', ''), '-', '') like '%{$request->numero_documento}%'");
            }else {
                $pessoas->where('pessoas.documento', 'like', "%{$request->numero_documento}%");
            }
        }

        if ($request->has('data_nascimento') && $request->data_nascimento) {
            $pessoas->where('pessoas.data_nascimento', $request->data_nascimento);
        }

        if ($request->has('telefone1') && $request->telefone1) {
            $pessoas->where('pessoas.telefone1', $request->telefone1);
        }

        if ($request->has('ordem') && $request->ordem) {
            $ordemArr = $request->ordem;
            $colunas_arr = [
                0 => 'nome',
                1 => 'tipo_documento',
                2 => 'documento',
                3 => 'data_nascimento',
                4 => 'celular',
            ];

            foreach($ordemArr as $ordem) {
                $key = $ordem[0];
                $direction = strtolower($ordem[1]) == 'desc' ? 'desc' : 'asc';
                if (isset($colunas_arr[$key])) {
                    $pessoas->orderBy($colunas_arr[$key], $direction);
                }
            }
        }

        // $sql = $portarias->toSql();
        // $bindings = $portarias->getBindings();

        // // Substituir os bindings na query para visualização
        // foreach ($bindings as $binding) {
        //    $binding = is_numeric($binding) ? $binding : "'$binding'";
        //    $sql = preg_replace('/\?/', $binding, $sql, 1);
        // }
        // Log::info('Query gerada: ' . $sql);

        $pessoas = $pessoas->get();

        return view('pessoas.tabela', ['pessoas' => $pessoas]);

    }

    public function getPessoasDataTable(Request $request)
    {
        $pessoas = DB::table('pessoas')
            ->select(
                'pessoas.id',
                'pessoas.nome',
                'pessoas.tipo_documento',
                'pessoas.documento',
                'pessoas.data_nascimento',
                DB::raw("DATE_FORMAT(pessoas.data_nascimento, '%d/%m/%Y') as data_nascimento_formatada"),
                'pessoas.telefone1',
                DB::raw("IF(pessoas.deleted_at IS NULL, 'Ativo', 'Inativo') as status")
            );

        if ($request->has('nome') && $request->nome) {
            $pessoas->where('pessoas.nome', 'like', "%{$request->nome}%");
        }

        if ($request->has('tipo_documento') && $request->tipo_documento) {
            $pessoas->where('pessoas.tipo_documento', "{$request->tipo_documento}");
        }

        if ($request->has('numero_documento') && $request->numero_documento) {
            if(!($request->has('tipo_documento') && $request->tipo_documento)){
                $pessoas->whereRaw("REPLACE(REPLACE(pessoas.documento, '.', ''), '-', '') like '%{$request->numero_documento}%'");
            }else {
                $pessoas->where('pessoas.documento', 'like', "%{$request->numero_documento}%");
            }
        }

        if ($request->has('data_nascimento') && $request->data_nascimento) {
            $pessoas->where('pessoas.data_nascimento', $request->data_nascimento);
        }

        if ($request->has('telefone1') && $request->telefone1) {
            $pessoas->where('pessoas.telefone1', $request->telefone1);
        }

        $sql = $pessoas->toSql();
        $bindings = $pessoas->getBindings();

        // Substituir os bindings na query para visualização
        foreach ($bindings as $binding) {
           $binding = is_numeric($binding) ? $binding : "'$binding'";
           $sql = preg_replace('/\?/', $binding, $sql, 1);
        }
        Log::info('Query gerada: ' . $sql);

        $pessoas = $pessoas->get();

        return DataTables::of($pessoas)
        ->editColumn('data_nascimento', function($row) {
            // Retorna a data formatada e define o atributo data-order para a ordenação correta
            return '<span data-order="' . $row->data_nascimento . '">' . $row->data_nascimento_formatada . '</span>';
        })
        ->addColumn('acao', function ($pessoa) {
            $actions = "<div style='white-space: nowrap;'>";

            if (Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 1) { // Master ou Agente Portaria
                if ($pessoa->status == 'Ativo'){
                    $actions .= "<a class='btn btn-opaque-semas me-2' href='"
                                . route('visita.create', ['id' => $pessoa->id, 'nome' => $pessoa->nome, 'documento' => $pessoa->documento])
                                . "' title='Criar Visita'><span><i class='bi bi-plus-circle'></i></span></a>";
                }
            }

            $actions .= "<a class='btn btn-opaque-semas me-2' href='"
                        . route('pessoa.show', ['pessoa' => $pessoa->id])
                        . "'><span><i class='bi bi-eye-fill'></i></span></a>";

            if (Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 1) { // Master ou Agente Portaria
                $actions .= "<a class='btn btn-opaque-semas me-2' href='"
                            . route('pessoa.edit', ['pessoa' => $pessoa->id])
                            . "'><span><i class='bi bi-pencil-fill'></i></span></a>";
            }

            if (Auth::user()->perfil_id == 3) { // Master
                if ($pessoa->status == 'Ativo') {
                    $deleteModalArr = json_encode([
                        'id' => $pessoa->id,
                        'message' => 'Deseja mesmo desativar a pessoa ' . $pessoa->nome . ' ?',
                        'route' => route('pessoa.destroy', ['id' => $pessoa->id])
                    ]);

                    $actions .= "<label onclick='modalDelete({$deleteModalArr})' class='btn btn-opaque-semas-danger me-1'>
                                    <span><i class='bi bi-trash-fill'></i></span>
                                </label>";
                } else {
                    $enableUrl = route('pessoa.enable', ['id' => $pessoa->id]);
                    $actions .= "<a class='btn btn-opaque-semas me-1' href='{$enableUrl}'>
                                    <span><i class='bi bi-arrow-counterclockwise'></i></span>
                                </a>";
                }
            }
            $actions .= "</div>";
            return $actions;
        })
        ->rawColumns(['data_nascimento', 'acao'])
        ->make(true);
    }
}
