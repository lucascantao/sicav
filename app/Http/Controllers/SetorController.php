<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setor;
use App\Models\User;
use App\Models\Registro;
use Illuminate\Support\Carbon;


class SetorController extends Controller
{
    public function index() {
        $setores = Setor::orderBy('sigla', 'asc')->get();
        return view('setores.index',['setores' => $setores]);
    }

    public function create() {
        return view('setores.create');
    }

    public function show(Setor $setor) {
        if (!$setor) {
            return redirect()->route('setores.index')->with('error', 'Setor não encontrado.');
        }
        return view('setores.show', ['setor' => $setor]);
    }

    public function edit(Setor $setor) {
        return view('setores.edit',['setor' => $setor]);
    }

    public function store(Request $request) {
        //Mensagens de validação
        $messages = [
            'sigla.unique' => 'A sigla já está em uso.',
            'nome.unique' => 'O nome já está em uso.',
        ];

        $data = $request-> validate([
            'nome' => 'required|string|unique:setores,nome',
            'sigla' => 'required|string|unique:setores,sigla',
        ], $messages);

        $data['nome'] = mb_strtoupper($data['nome'],"utf-8" );
        $data['sigla'] = mb_strtoupper($data['sigla'],"utf-8" );

        // $novoSetor = Setor::create($data);

        // return redirect(route('setor.index'));

        try {
            Setor::create($data);

            return redirect(route('setor.index'))->with('success', 'Setor criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao criar o setor.']);
        }
    }

    public function update(Setor $setor, Request $request) {
        $messages = [
            'sigla.unique' => 'A sigla já está em uso.',
            'nome.unique' => 'O nome já está em uso.',
        ];

        $data = $request-> validate([
            'nome' => 'required|string|unique:setores,nome,' . $setor->id,
            'sigla' => 'required|string|unique:setores,sigla,' . $setor->id,
        ], $messages);

        $data['nome'] = mb_strtoupper($data['nome'],"utf-8" );
        $data['sigla'] = mb_strtoupper($data['sigla'],"utf-8" );

        try{
            $setor->update($data);

            return redirect(route('setor.index'))->with('success','Setor editado com sucesso!');
        }catch(\Excepition $e){
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao editar setor']);
        };
    }

    public function softDelete($id_setor){
        $setor = Setor::find($id_setor);
        $currentDateTime = Carbon::now()->toDateTimeString();
        $setor->deleted_at = $currentDateTime;
        //$setor->deleted_by = Auth::user()->id;
        $setor->save();

        return redirect(route('setor.index'))->with('success','Setor desativado com sucesso!');
    }

    public function enable($id_setor) {
        $setor = Setor::find($id_setor);
        $setor->deleted_at = null;
        //$setor->deleted_by = null;
        $setor->save();

        return redirect(route('setor.index'))->with('success','Setor habilitado com sucesso!');
    }

    public function destroy($id) {

        if(User::where('setor_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('setor.index'))->with('failed', 'Não é possível excluir o setor, pois contém usuários registrados');
        }

        if(Registro::where('setor_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('setor.index'))->with('failed', 'Não é possível excluir o setor, pois existem registros que o usam');
        }

        $setor = Setor::find($id);
        $setor->delete();
        return redirect(route('setor.index'))->with('success', 'Setor excluído  com sucesso!');
    }

    public function gerarRelatorio(Request $request){

        $setorSigla = $request->input('sigla');
        $setorNome = $request->input('nome');
        $ordemArr = $request->input('ordem');

        $colunas_arr = [
            1 => 'sigla',
            2 => 'nome'
        ];

        $query = Setor::query();

        if (!empty($setorSigla)) {
            $query->where('sigla', 'LIKE', '%' . $setorSigla . '%');
        }

        if (!empty($setorNome)) {
            $query->where('nome', 'LIKE', '%' . $setorNome . '%');
        }

        foreach($ordemArr as $ordem) {
            $key = $ordem[0];
            $direction = strtolower($ordem[1]) == 'desc' ? 'desc' : 'asc';
            $query->orderBy($colunas_arr[$key], $direction);
        }

        $setores = $query->get();

        return view('setores.relatorio', compact('setores'));
    }

}
