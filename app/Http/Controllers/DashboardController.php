<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Permissão negada.');
        }

        $roles = Auth::user()->roles()->pluck('name')->toArray();

        if (in_array('admin', $roles)) {
            return view('pages.dashboard.admin');
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
