<?php

namespace App\Http\Controllers;

use App\Models\GymClosure;
use Illuminate\Http\Request;

class GymClosureController extends Controller
{
    public function index()
    {
        $closures = GymClosure::all();
        return view('pages.settings.closures', compact('closures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'closure_date' => 'required|date',
        ]);

        GymClosure::create($request->all());

        return redirect()->route('pages.settings.closures')->with('success', 'Datas de fecho adicionadas com sucesso.');
    }

    public function destroy(GymClosure $gymClosure)
    {
        $gymClosure->delete();

        return redirect()->route('pages.settings.closures')->with('success', 'Datas de fecho removidas com sucesso.');
    }
}
