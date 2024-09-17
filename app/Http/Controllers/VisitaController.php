<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Setor;
use App\Models\Empresa;
use App\Models\Unidade;
use App\Models\Servidor;
use App\Models\Visita;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use DateTime;

class VisitaController extends Controller
{
    //
    public function index() {
        //$visitas = Visita::all();
        $setores = Setor::all()->sortBy('sigla');
        $visitas = Visita::with('pessoa')->get();
        return view('visitas.index',['visitas' => $visitas , 'setores' => $setores]);
    }

    public function create(Request $request) {
        $pessoa_id = $request->input('id');
        $pessoa_nome = $request->input('nome');
        $pessoa_documento = $request->input('documento');

        $setores = Setor::orderBy('nome', 'asc')->get();
        $empresas = Empresa::orderBy('nome', 'asc')->get();
        $unidades = Unidade::orderBy('nome', 'asc')->get();
        $servidores = Servidor::where('status', '=', 'Ativo')
                                ->whereNotNull('setor_id')
                                ->orderBy('nome', 'asc')
                                ->get();

        $id_usuario = Auth::user()->id;

        return view('visitas.create' ,['pessoa_id' => $pessoa_id, 'pessoa_nome' => $pessoa_nome, 'pessoa_documento' => $pessoa_documento,
                    'setores' => $setores, 'unidades' => $unidades, 'empresas' => $empresas,'id_usuario' => $id_usuario, 'servidores' => $servidores]);

    }

    public function edit(Visita $visita) {

        $setores = Setor::orderBy('nome', 'asc')->get();
        $empresas = Empresa::orderBy('nome', 'asc')->get();
        $unidades = Unidade::orderBy('nome', 'asc')->get();
        $servidores = Servidor::orderBy('nome', 'asc')->get();


        return view('visitas.edit',['setores' => $setores, 'unidades' => $unidades, 'empresas' => $empresas, 'visita' => $visita, 'servidores' => $servidores]);
    }

    public function store(Request $request) {

        $visita = $request->all();

        try{
            Visita::create($visita);

            return redirect(route('visita.index'))->with('success' , 'Visita criada com sucesso');

        // return redirect('/pessoa');
        }catch(\Exception $e){
            return redirect()->back()->withInput()->withErrors(['errors' => 'Ocorreu um erro ao criar a Visita']);
        }
    }

    public function show(Visita $visita) {
        $visita = Visita::find($visita->id);
        return view('visitas.show', compact('visita'));
    }

    public function update($id_visita, Request $request) {

        $visita = Visita::find($id_visita);
        $visita2 = $request->all();
        $visita2['usuario_cadastro_id'] = Auth::user()->id;

        $visita->update($visita2);
        return redirect(route('visita.index'))->with('success','Visita editada com sucesso!');
    }

    public function softDelete($id_visita){
        $visita = Visita::find($id_visita);
        $currentDateTime = Carbon::now()->toDateTimeString();
        $visita->deleted_at = $currentDateTime;
        //$visita->deleted_by = Auth::user()->id;
        $visita->save();

        return redirect(route('visita.index'))->with('success','Visita desativada com sucesso!');
    }

    public function enable($id_visita) {
        $visita = Visita::find($id_visita);
        $visita->deleted_at = null;
        //$visita->deleted_by = null;
        $visita->save();

        return redirect(route('visita.index'))->with('success','Visita habilitada com sucesso!');
    }

    public function destroy($id) {

        if(User::where('visita_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('visita.index'))->with('failed', 'Não é possível excluir a visita, pois existem registros que a usam');
        }

        if(Registro::where('visita_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('visita.index'))->with('failed', 'Não é possível excluir a visita, pois existem registros que a usam');
        }

        $visita = Visita::find($id);
        $visita->delete();
        return redirect(route('visita.index'))->with('success', 'Visita excluída  com sucesso!');
    }

    public function gerarRelatorio(Request $request){

        $visitanteNome = $request->input('visitante');
        $visitanteDocumento = $request->input('documento');
        $visitanteTelefone = $request->input('telefone');
        $visitanteSetor = $request->input('setor');
        $visitanteServidor = $request->input('servidor');
        $visitanteDataInicio = $request->input('date_start');
        $visitanteDataFinal = $request->input('date_end');
        $ordemArr = $request->input('ordem');

        $colunas_arr = [
            0 => 'pessoas.nome',
            2 => 'pessoas.documento',
            3 => 'pessoas.telefone1',
            4 => 'visitas.created_at',
            5 => 'setores.sigla',
            6 => 'servidores.nome',
        ];

        $query = Visita::query();

        if (!empty($visitanteNome)) {
            $query->whereHas('pessoa', function ($q) use ($visitanteNome) {
                $q->where('nome', 'LIKE', '%' . $visitanteNome . '%');
            });
        }

        if (!empty($visitanteDocumento)) {
            $query->whereHas('pessoa', function ($q) use ($visitanteDocumento) {
                $q->where('documento', 'LIKE', '%' . $visitanteDocumento . '%');
            });
        }

        if (!empty($visitanteTelefone)) {
            $query->whereHas('pessoa', function ($q) use ($visitanteTelefone) {
                $q->where('telefone1', 'LIKE', '%' . $visitanteTelefone . '%');
            });
        }

        if (!empty($visitanteSetor)) {
            $query->whereHas('setor', function ($q) use ($visitanteSetor) {
                $q->where('sigla', 'LIKE', '%' . $visitanteSetor . '%');
            });
        }

        if (!empty($visitanteServidor)) {
            $query->whereHas('servidor', function ($q) use ($visitanteServidor) {
                $q->where('nome', 'LIKE', '%' . $visitanteServidor . '%');
            });
        }

        if (!empty($visitanteDataInicio) && !empty($visitanteDataFinal)) {
            $visitanteDataInicio = \DateTime::createFromFormat('d/m/Y', $visitanteDataInicio)->format('Y-m-d 00:00:00');
            $visitanteDataFinal = \DateTime::createFromFormat('d/m/Y', $visitanteDataFinal)->format('Y-m-d 23:59:59');
            $query->whereBetween('created_at', [$visitanteDataInicio, $visitanteDataFinal]);
        } elseif (!empty($visitanteDataInicio)) {
            $visitanteDataInicio = \DateTime::createFromFormat('d/m/Y', $visitanteDataInicio)->format('Y-m-d 00:00:00');
            $query->where('created_at', '>=', $visitanteDataInicio);
        } elseif (!empty($visitanteDataFinal)) {
            $visitanteDataFinal = \DateTime::createFromFormat('d/m/Y', $visitanteDataFinal)->format('Y-m-d 23:59:59');
            $query->where('created_at', '<=', $visitanteDataFinal);
        }

        $query->join('pessoas', 'visitas.pessoa_id', '=', 'pessoas.id')
              ->join('setores', 'visitas.setor_id', '=', 'setores.id')
              ->join('servidores', 'visitas.servidor_id', '=', 'servidores.id');

        foreach($ordemArr as $ordem) {
            $key = $ordem[0];
            $direction = strtolower($ordem[1]) == 'desc' ? 'desc' : 'asc';
            if (isset($colunas_arr[$key])) {
                $query->orderBy($colunas_arr[$key], $direction);
            }
        }

        $visitas = $query->select('visitas.*')->with(['pessoa', 'setor', 'servidor'])->get();

        return view('visitas.relatorio', compact('visitas'));
    }

    public function getVisitasTable(Request $request)
    {
        $visitas = DB::table('visitas')
            ->select(
                'visitas.id',
                'pessoas.nome',
                'pessoas.tipo_documento',
                'pessoas.documento',
                'pessoas.telefone1',
                'setores.sigla',
                'visitas.servidor',
                DB::raw("DATE_FORMAT(visitas.created_at, '%d/%m/%Y %H:%i:%s') as created_at_formatada"),
                DB::raw("IF(visitas.deleted_at IS NULL, 'Ativo', 'Inativo') as status")
            )
            ->join('pessoas' , 'visitas.pessoa_id' , '=' , 'pessoas.id')
            ->join('setores' , 'visitas.setor_id' , '=' , 'setores.id');

        if ($request->has('nome') && $request->nome) {
            $visitas->where('pessoas.nome', 'like', "%{$request->nome}%");
        }

        if ($request->has('tipo_documento') && $request->tipo_documento) {
            $visitas->where('pessoas.tipo_documento', 'like', "%{$request->tipo_documento}%");
        }

        if ($request->has('numero_documento') && $request->numero_documento) {
                $visitas->whereRaw("REPLACE(REPLACE(pessoas.documento, '.', ''), '-', '') like '%{$request->numero_documento}%'");
        }

        if ($request->has('telefone') && $request->telefone) {
            $visitas->where('pessoas.telefone1', $request->telefone);
        }

        if ($request->has('setor') && $request->setor) {
            $visitas->where('setores.sigla', $request->setor);
        }

        if ($request->has('servidor') && $request->servidor) {
            $visitas->where('visitas.servidor', 'like', "%{$request->servidor}%");
        }

        // Filtro por intervalo de data
		if ($request->has('data_inicio') && $request->data_inicio && $request->has('data_fim') && $request->data_fim) {
			$dateObj = DateTime::createFromFormat('d/m/Y', $request->data_inicio);
			$dataInicio = $dateObj->format('Y-m-d');

            $dateObj = DateTime::createFromFormat('d/m/Y', $request->data_fim);
			$dataFim = $dateObj->format('Y-m-d');

			$visitas->whereBetween('visitas.created_at', [$dataInicio, $dataFim]);
		} elseif ($request->has('data_inicio') && $request->data_inicio) {
			$dateObj = DateTime::createFromFormat('d/m/Y', $request->data_inicio);
			$dataInicio = $dateObj->format('Y-m-d');

            $visitas->where('visitas.created_at', '>=', $dataInicio);
		} elseif ($request->has('data_fim') && $request->data_fim) {
			$dateObj = DateTime::createFromFormat('d/m/Y', $request->data_fim);
			$dataFim = $dateObj->format('Y-m-d');

            $visitas->where('visitas.created_at', '<=', $dataFim);
		}

        if ($request->has('ordem') && $request->ordem) {
            $ordemArr = $request->ordem;
            $colunas_arr = [
                0 => 'nome',
                1 => 'pessoas.tipo_documento',
                2 => 'pessoas.documento',
                3 => 'created_at_formatada',
                4 => 'setores.sigla',
                5 => 'visitas.servidor',
            ];

            foreach($ordemArr as $ordem) {
                $key = $ordem[0];
                $direction = strtolower($ordem[1]) == 'desc' ? 'desc' : 'asc';
                if (isset($colunas_arr[$key])) {
                    $visitas->orderBy($colunas_arr[$key], $direction);
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

        $visitas = $visitas->get();

        return view('visitas.tabela', ['visitas' => $visitas]);

    }

    public function getVisitasDataTable(Request $request)
    {
        $visitas = DB::table('visitas')
            ->select(
                'visitas.id',
                'pessoas.nome',
                'pessoas.tipo_documento',
                'pessoas.documento',
                'pessoas.telefone1',
                'setores.sigla',
                'visitas.servidor',
                'visitas.created_at',
                DB::raw("DATE_FORMAT(visitas.created_at, '%d/%m/%Y %H:%i:%s') as created_at_formatada"),
                DB::raw("IF(visitas.deleted_at IS NULL, 'Ativo', 'Inativo') as status")
            )
            ->join('pessoas' , 'visitas.pessoa_id' , '=' , 'pessoas.id')
            ->join('setores' , 'visitas.setor_id' , '=' , 'setores.id')
            ->orderBy('created_at_formatada' , 'desc');

        if ($request->has('nome') && $request->nome) {
            $visitas->where('pessoas.nome', 'like', "%{$request->nome}%");
        }

        if ($request->has('tipo_documento') && $request->tipo_documento) {
            $visitas->where('pessoas.tipo_documento', 'like', "%{$request->tipo_documento}%");
        }

        if ($request->has('numero_documento') && $request->numero_documento) {
                $visitas->whereRaw("REPLACE(REPLACE(pessoas.documento, '.', ''), '-', '') like '%{$request->numero_documento}%'");
        }

        if ($request->has('telefone') && $request->telefone) {
            $visitas->where('pessoas.telefone1', $request->telefone);
        }

        if ($request->has('setor') && $request->setor) {
            $visitas->where('setores.sigla', $request->setor);
        }

        if ($request->has('servidor') && $request->servidor) {
            $visitas->where('visitas.servidor', 'like', "%{$request->servidor}%");
        }

        // Filtro por intervalo de data
		if ($request->has('data_inicio') && $request->data_inicio && $request->has('data_fim') && $request->data_fim) {
			$dateObj = DateTime::createFromFormat('d/m/Y', $request->data_inicio);
			$dataInicio = $dateObj->format('Y-m-d');

            $dateObj = DateTime::createFromFormat('d/m/Y', $request->data_fim);
			$dataFim = $dateObj->format('Y-m-d');

			$visitas->whereBetween('visitas.created_at', [$dataInicio, $dataFim]);
		} elseif ($request->has('data_inicio') && $request->data_inicio) {
			$dateObj = DateTime::createFromFormat('d/m/Y', $request->data_inicio);
			$dataInicio = $dateObj->format('Y-m-d');

            $visitas->where('visitas.created_at', '>=', $dataInicio);
		} elseif ($request->has('data_fim') && $request->data_fim) {
			$dateObj = DateTime::createFromFormat('d/m/Y', $request->data_fim);
			$dataFim = $dateObj->format('Y-m-d');

            $visitas->where('visitas.created_at', '<=', $dataFim);
		}

        $sql = $visitas->toSql();
        $bindings = $visitas->getBindings();

        // Substituir os bindings na query para visualização
        foreach ($bindings as $binding) {
           $binding = is_numeric($binding) ? $binding : "'$binding'";
           $sql = preg_replace('/\?/', $binding, $sql, 1);
        }
        Log::info('Query gerada: ' . $sql);

        $visitas = $visitas->get();

        return DataTables::of($visitas)
        ->editColumn('data', function($visita) {
            // Retorna a data formatada e define o atributo data-order para a ordenação correta
            return '<span data-order="' . $visita->created_at . '">' . $visita->created_at_formatada . '</span>';
        })
        ->addColumn('acao', function ($visita) {
            $actions = "<div style='white-space: nowrap;'>";

            $actions .= "<a class='btn btn-opaque-semas me-2' href='"
                        . route('visita.show', ['visita' => $visita->id])
                        . "'><span><i class='bi bi-eye-fill'></i></span></a>";

            if (Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 1) { // Master ou Agente Portaria
                $actions .= "<a class='btn btn-opaque-semas me-2' href='"
                            . route('visita.edit', ['visita' => $visita->id])
                            . "'><span><i class='bi bi-pencil-fill'></i></span></a>";
            }

            if (Auth::user()->perfil_id == 3) { // Master
                if ($visita->status == 'Ativo') {
                    $deleteModalArr = json_encode([
                        'id' => $visita->id,
                        'message' => 'Deseja mesmo excluir a visita de ' . $visita->nome . ' ?',
                        'route' => route('visita.destroy', ['id' => $visita->id])
                    ]);

                    $actions .= "<label onclick='modalDelete({$deleteModalArr})' class='btn btn-opaque-semas-danger me-1'>
                                    <span><i class='bi bi-trash-fill'></i></span>
                                </label>";
                } else {
                    $enableUrl = route('visita.enable', ['id' => $visita->id]);
                    $actions .= "<a class='btn btn-opaque-semas me-1' href='{$enableUrl}'>
                                    <span><i class='bi bi-arrow-counterclockwise'></i></span>
                                </a>";
                }
            }
            $actions .= "</div>";
            return $actions;
        })
        ->rawColumns(['data', 'acao'])
        ->make(true);
    }

}
