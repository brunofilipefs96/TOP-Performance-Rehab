<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $requiredSettings = [
            'taxa_inscricao',
            'taxa_seguro',
            'capacidade_maxima',
            'horario_inicio_semanal',
            'horario_fim_semanal',
            'horario_inicio_sabado',
            'horario_fim_sabado',
            'telemovel',
            'email',
            'top_paddle_client_membership_discount',
            'top_paddle_client_insurance_discount',
            'top_paddle_client_trainings_discount',
            'top_paddle_admin_membership_discount',
            'top_paddle_admin_insurance_discount',
            'top_paddle_admin_funcional_training_discount',
            'top_paddle_admin_personal_training_trainings_discount',
            'top_paddle_employee_membership_discount',
            'top_paddle_employee_insurance_discount',
            'top_paddle_employee_funcional_training_discount',
            'top_paddle_employee_personal_training_trainings_discount'
        ];

        foreach ($requiredSettings as $setting) {
            $settingValue = Setting::where('key', $setting)->value('value');
            if ($settingValue === null || $settingValue === '') {
                if (Auth::user() && Auth::user()->hasRole('admin')) {
                    return redirect()->route('settings.index')->withErrors(['error' => 'Por favor, preencha todas as configurações do ginásio.']);
                } else {
                    return redirect()->route('unavailable')->withErrors(['error' => 'Por favor, preencha todas as configurações do ginásio.']);
                }
            }
        }

        return $next($request);
    }
}
