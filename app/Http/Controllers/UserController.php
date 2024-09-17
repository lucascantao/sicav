<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perfil;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function index() {
        $user = Auth::user();
        $setores = Setor::all()->sortBy('sigla');
        $perfis = Perfil::all()->sortBy('nome');

        if($user->perfil_id < 3){
            $users = User::where('setor_id', '=', $user->setor_id)->orWhere('perfil_id','=', 3)->OrderBy('name')->get();
        } else {
            $users = User::all()->sortBy('name');
        }

        return view('users.index', [
            'users' => $users,
            'setores' => $setores,
            'perfis' => $perfis
        ]);
    }

    public function show(User $user) {
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Ususuário não encontrado.');
        }
        return view('users.show', ['user' => $user]);
    }

    public function enable($id) {
        $user = User::find($id);
        $user->deleted_at = null;
        $user->save();
        return redirect(route('user.index'))->with('success','Usuário habilitado com sucesso!');

    }

    public function edit($id) {
        $user = User::find($id);
        $setores = Setor::orderBy('sigla', 'asc')->get();
        $perfis = Perfil::where('id', '<=', Auth::user()->perfil_id)->get();
        return view('users.edit', [
            'user' => $user,
            'setores' => $setores,
            'perfis' => $perfis,
        ]);
    }

    public function update($id, Request $request) {
        $user = User::find($id);
        $data = $request->validate([
            'name' => 'required',
            'setor_id' => 'required',
            'perfil_id' => 'required',
        ]);



        $user->update($data);

        return redirect(route('user.index'))->with('success','Usuário editado com sucesso!');
    }

    public function disable($id, Request $request) {
        $user = User::find($id);
        $currentDateTime = Carbon::now()->toDateTimeString();
        $user->deleted_at = $currentDateTime;
        $user->save();

        if($user->id == Auth::user()->id) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect(route('login'))->with('failed','Seu usuário foi desabilitado');
        }else {
            return redirect(route('user.index'))->with('failed','Usuário desabilitado com sucesso!');
        }
    }

    public function softDelete($id_user){
        $user = User::find($id_user);
        $currentDateTime = Carbon::now()->toDateTimeString();
        $user->deleted_at = $currentDateTime;
        //$user->deleted_by = Auth::user()->id;
        $user->save();

        return redirect(route('user.index'))->with('success','Usuário desativado com sucesso!');
    }

    public function destroy($id) {

        if(User::where('user_id', '=', $id)->get()->isNotEmpty()){
            return redirect(route('user.index'))->with('failed', 'Não é possível excluir a user, pois existem registros que a usam');
        }

        $user = User::find($id);
        $user->delete();
        return redirect(route('user.index'))->with('success', 'Empresa excluída  com sucesso!');
    }

    public function gerarRelatorio(Request $request){

        $nome = $request->input('nome');
        $setor = $request->input('setor');
        $perfil = $request->input('perfil');
        $status = $request->input('status');
        $ordemArr = $request->input('ordem');

        $colunas_arr = [
            1 => 'users.name',
            2 => 'setores.sigla',
            3 => 'perfis.nome',
            4 => 'enabled'
        ];

        $query = User::query();

        if (!empty($nome)) {
            $query->where('name', 'LIKE', '%' . $nome . '%');
        }

        if (!empty($setor)) {
            $query->whereHas('setor', function ($q) use ($setor) {
                $q->where('nome', 'LIKE', '%' . $setor . '%');
            });
        }

        if (!empty($perfil)) {
            $query->whereHas('perfil', function ($q) use ($perfil) {
                $q->where('nome', 'LIKE', '%' . $perfil . '%');
            });
        }

        $query->join('setores', 'users.setor_id', '=', 'setores.id')
              ->join('perfis', 'users.perfil_id', '=', 'perfis.id');

        foreach($ordemArr as $ordem) {
            $key = $ordem[0];
            $direction = strtolower($ordem[1]) == 'desc' ? 'desc' : 'asc';
            if (isset($colunas_arr[$key])) {
                $query->orderBy($colunas_arr[$key], $direction);
            }
        }

        $usuarios = $query
                    ->select('users.*')->with(['setor', 'perfil'])
                    ->selectRaw('IF(users.deleted_at is null, "Habilitado", "Desabilitado") as enabled')
                    ->get();

        return view('users.relatorio', compact('usuarios'));
    }
}
