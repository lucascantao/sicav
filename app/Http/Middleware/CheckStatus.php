<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if(Auth::user()->deleted_at != null){
            return redirect(route('login', absolute: false));
        }

        if(Auth::user()->perfil_id != null && Auth::user()->deleted_at == null){
            return $next($request);
        }


        return redirect(route('status', absolute: false));

    }
}
