<?php

namespace App\Http\Controllers;

use App\Models\GymClosure;
use Illuminate\Http\Request;

class GymClosureController extends Controller
{
    public function index()
    {
        $closures = GymClosure::all()->pluck('closure_date')->toArray();
        return view('pages.settings.closures', compact('closures'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'closure_dates' => 'required|array',
            'closure_dates.*' => 'date',
        ]);

        GymClosure::truncate();
        foreach ($request->closure_dates as $date) {
            GymClosure::create(['closure_date' => $date]);
        }

        return redirect()->route('settings.closures')->with('success', 'Datas de Fecho do ginásio atualizadas com sucesso.');
    }
}
