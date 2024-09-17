<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidade;
use Illuminate\Support\Carbon;


class UnidadeController extends Controller
{
    //
    public function index() {
        $unidades = Unidade::orderBy('nome', 'asc')->get();
        return view('unidades.index',['unidades' => $unidades]);
    }

    public function create() {
        return view('unidades.create');
    }

    public function show(Unidade $unidade) {
        if (!$unidade) {
            return redirect()->route('unidadees.index')->with('error', 'Unidade não encontrada.');
        }
        return view('unidades.show', ['unidade' => $unidade]);
    }

    public function edit(Unidade $unidade) {
        return view('unidades.edit',['unidade' => $unidade]);
    }

    public function store(Request $request) {
        //Mensagens de validação
        $messages = [
            'nome.unique' => 'O nome já está em uso.',
        ];

        $data = $request-> validate([
            'nome' => 'required|string|unique:unidades,nome',
        ], $messages);

        $data['nome'] = mb_strtoupper($data['nome'],"utf-8" );

        try {
            Unidade::create($data);

            return redirect(route('unidade.index'))->with('success', 'Unidade criada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao criar a unidade.']);
        }
    }

    public function update(Unidade $unidade, Request $request) {
        // $unidade = Unidade::Find($id_unidade);
        $messages = [
            'nome.unique' => 'O nome da unidade já está em uso.',
        ];

        $data = $request-> validate([
            'nome' => 'required|string|unique:unidades,nome,' . $unidade->id,
        ], $messages);

        $data['nome'] = mb_strtoupper($data['nome'],"utf-8" );

       try{
        $unidade->update($data);

        return redirect(route('unidade.index'))->with('success','Unidade editada com sucesso!');
        } catch(\Exception $e){
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao editar unidade']);
        };
    }


    public function softDelete($id_unidade){
        $unidade = Unidade::find($id_unidade);
        $currentDateTime = Carbon::now()->toDateTimeString();
        $unidade->deleted_at = $currentDateTime;
        //$unidade->deleted_by = Auth::user()->id;
        $unidade->save();

        return redirect(route('unidade.index'))->with('success','Unidade desativada com sucesso!');
    }

    public function enable($id_unidade) {
        $unidade = Unidade::find($id_unidade);
        $unidade->deleted_at = null;
        //$unidade->deleted_by = null;
        $unidade->save();

        return redirect(route('unidade.index'))->with('success','Unidade habilitada com sucesso!');
    }


    public function destroy($id) {

        if(User::where('unidade_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('unidade.index'))->with('failed', 'Não é possível excluir a unidade, pois contém usuários registrados');
        }

        if(Registro::where('unidade_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('unidade.index'))->with('failed', 'Não é possível excluir a unidade, pois existem registros que o usam');
        }

        $unidade = Unidade::find($id);
        $unidade->delete();
        return redirect(route('unidade.index'))->with('success', 'Unidade excluída  com sucesso!');
    }

    public function gerarRelatorio(Request $request){

        $unidadeNome = $request->input('nome');
        $ordemArr = $request->input('ordem');

        $colunas_arr = [
            1 => 'nome',
        ];

        $query = Unidade::query();

        if (!empty($unidadeNome)) {
            $query->where('nome', 'LIKE', '%' . $unidadeNome . '%');
        }

        foreach($ordemArr as $ordem) {
            $key = $ordem[0];
            $direction = strtolower($ordem[1]) == 'desc' ? 'desc' : 'asc';
            $query->orderBy($colunas_arr[$key], $direction);
        }

        $unidades = $query->get();

        return view('unidades.relatorio', compact('unidadeNome', 'unidades'));
    }

}
