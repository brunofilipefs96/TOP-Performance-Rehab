<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MattDaneshvar\Survey\Models\Entry;
use MattDaneshvar\Survey\Models\Survey;

class EntryController extends Controller
{
    public function index(){
        return view('pages.entries.index', ['surveys' => Survey::all()]);
    }
    public function fill(Survey $survey){
        if ($survey->entriesFrom(Auth::user()->id)->exists()) {
            return redirect()->route('dashboard');
        }
        else
        {
            return view('pages.entries.fill', ['survey' => $survey]);
        }
    }

    public function store(Request $request){
        $survey = Survey::find($request->survey);

        $answers = $request->validate($survey->rules);

        (new Entry)->for($survey)->by(Auth::user())->fromArray($answers)->push();
    }
}
