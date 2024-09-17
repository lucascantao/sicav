<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Registro;

class RegistroProtectedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // dd($request->route());
        $registroRouteRegistroId = $request->route()->parameters()['id'];
        $registroRouteUserId = Registro::find($registroRouteRegistroId)->usuario_id;
        $registroRouteSetorId = Registro::find($registroRouteRegistroId)->setor_id;


        if(
            (Auth::user()->id == $registroRouteUserId)
            || (Auth::user()->perfil_id >= 2 && Auth::user()->setor_id == $registroRouteSetorId)
            || Auth::user()->perfil_id >= 3
            )
        {
            return $next($request);
        }

        return redirect(route('registro.index', absolute: false))->with('failed', 'Você não é autorizado a acessar essa registro');
    }
}
