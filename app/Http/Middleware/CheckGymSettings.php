<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckGymSettings
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
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('unavailable');
        }

        $requiredSettings = [
            'taxa_inscricao',
            'taxa_seguro',
            'capacidade_maxima',
            'percentagem_aulas_livres',
            'horario_inicio',
            'horario_fim',
        ];

        foreach ($requiredSettings as $setting) {
            if (!Setting::where('key', $setting)->exists()) {
                return redirect()->route('settings.index')->withErrors(['error' => 'Por favor, preencha todas as configurações do ginásio.']);
            }
        }

        return $next($request);
    }
}
