<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProtectedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = User::find($request->route()->parameters()['id']);

        $userRoutePerfilId = $user->perfil_id;
        $userRouteSetorId = $user->setor_id;

        if(
            (Auth::user()->perfil_id >= $userRoutePerfilId && Auth::user()->setor_id == $userRouteSetorId)
            || Auth::user()->perfil_id >= 3
            )
        {
            return $next($request);
        }

        return redirect(route('user.index', absolute: false));
    }
}
