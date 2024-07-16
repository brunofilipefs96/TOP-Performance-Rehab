<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->roles->isEmpty()) {
            return redirect()->route('no-roles')->withErrors(['error' => 'Você não possui cargos atribuídos. Por favor, contate um administrador.']);
        }

        return $next($request);
    }
}
