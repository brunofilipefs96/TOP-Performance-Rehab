<?php

namespace App\Http\Controllers;

use App\Models\FreeTraining;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FreeTrainingController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = auth()->user();
        $currentWeek = Carbon::now()->startOfWeek();
        $selectedWeek = $request->query('week') ? Carbon::parse($request->query('week'))->startOfWeek() : $currentWeek;
        $selectedDay = $request->query('day') ? Carbon::parse($request->query('day')) : null;

        if ($user->hasRole('client')) {
            if ($selectedWeek->lt($currentWeek)) {
                $selectedWeek = $currentWeek;
            } elseif ($selectedWeek->gt($currentWeek->copy()->addWeek())) {
                $selectedWeek = $currentWeek->copy()->addWeek();
            }
        }

        if ($selectedDay === null) {
            if ($selectedWeek->eq($currentWeek)) {
                $selectedDay = Carbon::now();
            } else {
                $selectedDay = $selectedWeek->copy()->startOfWeek();
            }
        }

        if ($selectedDay->dayOfWeek == Carbon::SUNDAY) {
            $selectedDay = $selectedDay->addDay();
        }

        Session::put('selected_week', $selectedWeek);
        Session::put('selected_day', $selectedDay);

        $freeTrainings = FreeTraining::whereBetween('start_date', [$selectedWeek, $selectedWeek->copy()->endOfWeek()])
            ->orderBy('start_date', 'asc')
            ->get()
            ->groupBy(function ($freeTraining) {
                return Carbon::parse($freeTraining->start_date)->format('Y-m-d');
            });

        $daysOfWeek = [];
        for ($date = $selectedWeek->copy()->startOfWeek(); $date->lte($selectedWeek->copy()->endOfWeek()); $date->addDay()) {
            $daysOfWeek[] = $date->format('Y-m-d');
        }

        $showMembershipModal = false;
        if ($user->hasRole('client') && (!auth()->user()->membership || auth()->user()->membership->status->name !== 'active') && !session()->has('free_trainings_membership_modal_shown')) {
            session(['free_trainings_membership_modal_shown' => true]);
            $showMembershipModal = true;
        }

        return view('pages.trainings.index', [
            'freeTrainings' => $freeTrainings,
            'currentWeek' => $currentWeek,
            'selectedWeek' => $selectedWeek,
            'daysOfWeek' => $daysOfWeek,
            'selectedDay' => $selectedDay,
            'showMembershipModal' => $showMembershipModal,
        ]);
    }

    public function changeWeek(Request $request)
    {
        $direction = $request->input('direction');
        $selectedWeek = Session::get('selected_week', Carbon::now()->startOfWeek());

        if ($direction === 'previous') {
            $selectedWeek = $selectedWeek->subWeek();
        } elseif ($direction === 'next') {
            $selectedWeek = $selectedWeek->addWeek();
        }

        $selectedDay = $selectedWeek->copy()->startOfWeek();

        Session::put('selected_week', $selectedWeek);
        Session::put('selected_day', $selectedDay);
        return redirect()->route('free_trainings.index', ['week' => $selectedWeek->format('Y-m-d')]);
    }

    public function selectDay(Request $request, $day)
    {
        $selectedDay = Carbon::parse($day);
        Session::put('selected_day', $selectedDay);
        return redirect()->route('free_trainings.index', ['day' => $selectedDay->format('Y-m-d'), 'week' => $selectedDay->startOfWeek()->format('Y-m-d')]);
    }

    public function enroll(Request $request, FreeTraining $freeTraining)
    {
        $user = auth()->user();

        if ($user->hasRole('client') && (!$user->membership || $user->membership->status->name !== 'active')) {
            return redirect()->route('free_trainings.index')->with('error', 'Você precisa de uma matrícula ativa para se inscrever neste treino.');
        }

        if ($freeTraining->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('free_trainings.index')->with('error', 'Já está inscrito neste treino livre.');
        }

        if ($freeTraining->users()->count() < $freeTraining->max_students) {
            $freeTraining->users()->attach($user->id);
            return redirect()->route('free_trainings.index')->with('success', 'Inscrição em treino livre realizada com sucesso.');
        } else {
            return redirect()->route('free_trainings.index')->with('error', 'O treino livre está cheio.');
        }
    }

    public function cancel(Request $request, FreeTraining $freeTraining)
    {
        $user = auth()->user();
        $freeTraining->users()->detach($user->id);
        return redirect()->route('free_trainings.index')->with('success', 'Inscrição em treino livre cancelada com sucesso.');
    }
}
