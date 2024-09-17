<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Setor;
use App\Models\Perfil;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $setores = Setor::orderBy('sigla', 'asc')->get();
        $perfis = Perfil::all();
        return view('auth.login',
            ['setores' => $setores],
            ['perfis' => $perfis],
    );
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        
        $username = $request->input('username');
        $password = $request->input('password');

        $user_on_database = User::where('username', '=', $username)->first();

        Auth::login($user_on_database);
        return redirect()->intended(route('pessoa.index', absolute: false));
        die();
        
        // $user_on_ldap = $this->autenticar($username, $password);

        // if($user_on_ldap['autenticacao_sucesso'] == 1) {

        //     if($user_on_database == null) {
        //         Session()->put('user', $user_on_ldap);
        //         return redirect(route('login'))->with('autenticado', 'Usuário autenticado');
        //     }

        //     if($user_on_database->deleted_at != null) {
        //         return redirect(route('login'))->with('failed', 'Sua conta foi desativada');
        //     }

        //     Auth::login($user_on_database);
        //     return redirect()->intended(route('pessoa.index', absolute: false));
        // }

        // return redirect(route('login'))->with('failed', 'Credenciais incorretas');

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'));
    }

    /**
     * Login no Ldap
     */

    public function autenticar($login = null, $senha = null) {

        $resposta = [];

        $url = trim("http://ldap-api.semas.local/api/autenticar?login=$login&senha=" . urlencode($senha));

        $_retorno = $this->do_get($url);

        if($_retorno['success']) {
            $resposta['autenticacao_sucesso'] = 1;
            $resposta['name'] = $_retorno['dados']['name'];
            $resposta['username'] = $_retorno['dados']['login'];
            $resposta['descricao'] = $_retorno['dados']['description'];
        } else {
            $resposta['autenticacao_sucesso'] = 0;
        }

        return $resposta;
    }
}
