<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MattDaneshvar\Survey\Models\Entry;
use MattDaneshvar\Survey\Models\Survey;

class EntryController extends Controller
{
    public function index(){
        return view('pages.entries.index', ['surveys' => Survey::all()]);
    }

    public function show(Entry $entry){

        $user = User::find($entry->participant_id);
        return view('pages.entries.show', ['entry' => $entry, 'user' => $user]);
    }

    public function fill(Survey $survey){
        if ($survey->entriesFrom(Auth::user())->exists()) {
            return redirect()->route('memberships.create');
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
        return redirect()->route('memberships.create');
    }
}
