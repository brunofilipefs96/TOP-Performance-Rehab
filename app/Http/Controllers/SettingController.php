<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('pages.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'taxa_inscricao' => 'required|numeric',
            'taxa_seguro' => 'required|numeric',
            'capacidade_maxima' => 'required|integer',
            'percentagem_aulas_livres' => 'required|numeric|min:0|max:100',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i',
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
            if (in_array($key, ['taxa_inscricao', 'taxa_seguro', 'capacidade_maxima', 'percentagem_aulas_livres', 'horario_inicio', 'horario_fim'])) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso.');
    }
}
