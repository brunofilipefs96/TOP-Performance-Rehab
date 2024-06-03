<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Permissão negada.');
        }

        $roles = Auth::user()->roles()->pluck('name')->toArray();

        // New members - Monthly and Annually
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

        if (in_array('admin', $roles)) {
            return view('pages.dashboard.admin', [
                'newMembersMonthly' => $newMembersMonthly,
                'newMembersAnnually' => $newMembersAnnually,
                'monthlyLabels' => $monthlyLabels,
                'monthlyData' => $monthlyData,
                'annualLabels' => $annualLabels,
                'annualData' => $annualData,
            ]);
        } elseif (in_array('client', $roles)) {
            return view('pages.dashboard.client');
        } elseif (in_array('personal_trainer', $roles)) {
            return view('pages.dashboard.personal-trainer');
        } elseif (in_array('employee', $roles)) {
            return view('pages.dashboard.employee');
        } else {
            abort(403, 'Permissão negada.');
        }
    }
}
