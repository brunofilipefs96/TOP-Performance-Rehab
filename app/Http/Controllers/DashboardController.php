<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }

        $user = Auth::user();
        $activeRole = $user->activeRole->name;

        // General data for the dashboard
        $newMembersMonthly = User::whereMonth('created_at', Carbon::now()->month)->count();
        $newMembersAnnually = User::whereYear('created_at', Carbon::now()->year)->count();

        // Last 30 days
        $monthlyLabels = collect();
        $monthlyData = collect();
        for ($i = 0; $i < Carbon::now()->daysInMonth; $i++) {
            $date = Carbon::now()->startOfMonth()->addDays($i);
            $monthlyLabels->push($date->format('d/m'));
            $monthlyData->push(User::whereDate('created_at', $date)->count());
        }

        // Last 12 months
        $annualLabels = collect();
        $annualData = collect();
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->startOfYear()->addMonths($i);
            $annualLabels->push($date->format('m/Y'));
            $annualData->push(User::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count());
        }

        switch ($activeRole) {
            case 'admin':
                return view('pages.dashboard.admin', [
                    'newMembersMonthly' => $newMembersMonthly,
                    'newMembersAnnually' => $newMembersAnnually,
                    'monthlyLabels' => $monthlyLabels,
                    'monthlyData' => $monthlyData,
                    'annualLabels' => $annualLabels,
                    'annualData' => $annualData,
                ]);
            case 'client':
                $products = Product::orderBy('created_at', 'desc')->take(6)->get();

                return view('pages.dashboard.client', [
                    'user' => $user,
                    'products' => $products,
                ]);
            case 'personal_trainer':
                return view('pages.dashboard.personal-trainer');
            case 'employee':
                return view('pages.dashboard.employee');
            default:
                abort(403, 'Unauthorized access.');
        }
    }

    public function showCalendar(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }

        $user = Auth::user();

        // Date manipulation for week navigation
        if (!$request->session()->has('selectedWeek')) {
            $request->session()->put('selectedWeek', Carbon::now()->startOfWeek());
        }

        $selectedWeek = Carbon::parse($request->session()->get('selectedWeek'));
        $startOfWeek = $selectedWeek->copy()->startOfWeek();
        $endOfWeek = $selectedWeek->copy()->endOfWeek();

        $trainings = $user->trainings()
            ->whereBetween('start_date', [$startOfWeek, $endOfWeek])
            ->get();

        return view('pages.dashboard.calendar', [
            'user' => $user,
            'trainings' => $trainings,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'selectedWeek' => $selectedWeek,
            'currentWeek' => Carbon::now()->startOfWeek()
        ]);
    }

    public function changeWeek(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }

        $selectedWeek = Carbon::parse($request->session()->get('selectedWeek'));
        $currentWeek = Carbon::now()->startOfWeek();
        $direction = $request->input('direction');

        if ($direction === 'previous' && $selectedWeek->gt($currentWeek)) {
            $newWeek = $selectedWeek->subWeek();
        } elseif ($direction === 'next' && $selectedWeek->lt($currentWeek->copy()->addWeeks(2))) {
            $newWeek = $selectedWeek->addWeek();
        } else {
            $newWeek = $selectedWeek;
        }

        $request->session()->put('selectedWeek', $newWeek->format('Y-m-d'));

        return redirect()->route('calendar');
    }
}
