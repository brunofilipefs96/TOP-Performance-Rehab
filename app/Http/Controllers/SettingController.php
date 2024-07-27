<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('unavailable');
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('pages.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('unavailable');
        }

        $request->validate([
            'email' => 'required|email',
            'telemovel' => 'required|digits:9',
            'taxa_inscricao' => 'required|numeric',
            'taxa_seguro' => 'required|numeric',
            'capacidade_maxima' => 'required|integer',
            'horario_inicio_semanal' => 'required|date_format:H:i',
            'horario_fim_semanal' => 'required|date_format:H:i',
            'horario_inicio_sabado' => 'required|date_format:H:i',
            'horario_fim_sabado' => 'required|date_format:H:i',
            'top_paddle_client_membership_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_client_insurance_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_client_trainings_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_admin_membership_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_admin_insurance_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_admin_funcional_training_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_admin_personal_training_trainings_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_employee_membership_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_employee_insurance_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_employee_funcional_training_discount' => 'required|numeric|min:0|max:100',
            'top_paddle_employee_personal_training_trainings_discount' => 'required|numeric|min:0|max:100',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
            'max' => 'O campo :attribute deve ser no máximo :max.',
            'date_format' => 'O campo :attribute não está no formato correto (HH:mm).',
            'email' => 'O campo :attribute deve ser um endereço de email válido.',
            'digits' => 'O campo :attribute deve ter exatamente :digits dígitos.'
        ]);

        $data = $request->all();
        $settingsKeys = [
            'email',
            'telemovel',
            'taxa_inscricao',
            'taxa_seguro',
            'capacidade_maxima',
            'horario_inicio_semanal',
            'horario_fim_semanal',
            'horario_inicio_sabado',
            'horario_fim_sabado',
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

        foreach ($settingsKeys as $key) {
            if (isset($data[$key])) {
                Setting::updateOrCreate(['key' => $key], ['value' => $data[$key]]);
            }
        }

        $closures = $request->input('closure_dates', []);
        $currentYear = date('Y');
        $sundays = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDayOfMonth = new \DateTime("$currentYear-$month-01");
            $dayOfWeek = $firstDayOfMonth->format('N');
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $currentYear);
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = new \DateTime("$currentYear-$month-$day");
                if ($date->format('N') == 7) { // Se for domingo
                    $sundays[] = $date->format('Y-m-d');
                }
            }
        }

        $closures = array_unique(array_merge($closures, $sundays));

        Setting::updateOrCreate(['key' => 'closure_dates'], ['value' => json_encode($closures)]);

        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso.');
    }
}
