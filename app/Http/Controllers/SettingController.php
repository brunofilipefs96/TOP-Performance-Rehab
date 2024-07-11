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
            'taxa_inscricao' => 'required|numeric',
            'taxa_seguro' => 'required|numeric',
            'capacidade_maxima' => 'required|integer',
            'horario_inicio_semanal' => 'required|date_format:H:i',
            'horario_fim_semanal' => 'required|date_format:H:i',
            'horario_inicio_sabado' => 'required|date_format:H:i',
            'horario_fim_sabado' => 'required|date_format:H:i',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
            'max' => 'O campo :attribute deve ser no máximo :max.',
            'date_format' => 'O campo :attribute não está no formato correto (HH:mm).',
        ]);

        $data = $request->all();
        foreach ($data as $key => $value) {
            if (in_array($key, ['taxa_inscricao', 'taxa_seguro', 'capacidade_maxima', 'horario_inicio_semanal', 'horario_fim_semanal', 'horario_inicio_sabado', 'horario_fim_sabado'])) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso.');
    }
}
