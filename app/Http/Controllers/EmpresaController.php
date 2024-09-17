<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Carbon;


class EmpresaController extends Controller
{
    public function index() {
        $empresas = Empresa::orderBy('nome', 'asc')->get();
        return view('empresas.index',['empresas' => $empresas]);
    }

    public function create() {
        return view('empresas.create');
    }

    public function show(Empresa $empresa) {
        if (!$empresa) {
            return redirect()->route('empresas.index')->with('error', 'Empresa não encontrada.');
        }
        return view('empresas.show', ['empresa' => $empresa]);
    }

    public function edit(Empresa $empresa) {
        return view('empresas.edit',['empresa' => $empresa]);
    }

    private function validacaoEmpresa($cnpj){
        if (!$this->validaCNPJ($cnpj)) {
            return ['error' => 'Número de CNPJ inválido'];
        }
    }

    public function store(Request $request) {
        $messages = [
            'nome.unique' => 'O nome já está em uso.',
        ];

        $request-> validate([
            'nome' => 'required|string|unique:empresas,nome',
        ], $messages);

        if (!empty($request['cnpj'])){
            $var = $this->validacaoEmpresa($request['cnpj']);
            if ($var) {
                return redirect()->back()->withInput()->withErrors($var);
            }
        }

        try{
            Empresa::create([
                'nome' => mb_strtoupper($request['nome'] , "utf-8"),
                'cnpj' => $request['cnpj'],
                'tel_contato' => $request['tel_contato']
            ]);

            return redirect(route('empresa.index'))->with('success' , 'Empresa criada com sucesso');
        } catch(\Exception $e) {
            return redirect()->back()->withInput()->witchErrors(['error' => 'Ocorreu um erro ao criar a Empresa']);
        }
    }

    public function update($id_empresa, Request $request) {

        $empresa = Empresa::find($id_empresa);

        $messages = [
            'nome.unique' => 'O nome já está em uso.',
        ];

        $request-> validate([
            'nome' => 'required|string|unique:empresas,nome,' . $id_empresa,
        ], $messages);

        $var = $this->validacaoEmpresa($request['cnpj']);

        if ($var) {
            return redirect()->back()->withInput()->withErrors($var);
        }

        $empresa->nome = mb_strtoupper($request['nome'] , "utf-8");
        $empresa->cnpj = $request['cnpj'];
        $empresa->tel_contato = $request['tel_contato'];

        try{
        $empresa->save();
        return redirect(route('empresa.index'))->with('success','Empresa editado com sucesso!');
        }catch(\Excepetion $e){
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao editar a Empresa']);
        };
    }

    public function softDelete($id_empresa){
        $empresa = Empresa::find($id_empresa);
        $currentDateTime = Carbon::now()->toDateTimeString();
        $empresa->deleted_at = $currentDateTime;
        $empresa->save();

        return redirect(route('empresa.index'))->with('success','Empresa desativada com sucesso!');
    }

    public function enable($id_empresa) {
        $empresa = Empresa::find($id_empresa);
        $empresa->deleted_at = null;
        $empresa->save();

        return redirect(route('empresa.index'))->with('success','Empresa habilitada com sucesso!');
    }

    public function destroy($id) {

        if(User::where('empresa_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('empresa.index'))->with('failed', 'Não é possível excluir a empresa, pois existem registros que a usam');
        }

        if(Registro::where('empresa_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('empresa.index'))->with('failed', 'Não é possível excluir a empresa, pois existem registros que a usam');
        }

        $empresa = Empresa::find($id);
        $empresa->delete();
        return redirect(route('empresa.index'))->with('success', 'Empresa excluída  com sucesso!');
    }

    public function gerarRelatorio(Request $request){

        $empresaNome = $request->input('nome');
        $empresaCNPJ = $request->input('cnpj');
        $empresaTelefone = $request->input('tel_contato');
        $ordemArr = $request->input('ordem');

        $colunas_arr = [
            0 => 'nome',
            1 => 'cnpj',
            2 => 'tel_contato'
        ];

        $query = Empresa::query();

        if (!empty($empresaNome)) {
            $query->where('nome', 'LIKE', '%' . $empresaNome . '%');
        }

        if (!empty($empresaCNPJ)) {
            $query->where('cnpj', 'LIKE', '%' . $empresaCNPJ . '%');
        }

        if (!empty($empresaTelefone)) {
            $query->where('tel_contato', 'LIKE', '%' . $empresaTelefone . '%');
        }

        foreach($ordemArr as $ordem) {
            $key = $ordem[0];
            $direction = strtolower($ordem[1]) == 'desc' ? 'desc' : 'asc';

            $query->orderBy($colunas_arr[$key], $direction);
        }

        $empresas = $query->get();

        return view('empresas.relatorio', compact('empresas'));
    }
}
