<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\TrainingType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetupController extends Controller
{
    use AuthorizesRequests;
    public function addressShow()
    {

        $user = auth()->user();
        $this->authorize('view', $user);

        return view('pages.setup.addressShow', ['user' => $user]);
    }

    public function membershipShow()
    {
        $user = auth()->user();
        $this->authorize('view', $user);

        return view('pages.setup.membershipShow', ['user' => $user]);
    }

    public function trainingTypesShow()
    {
        $user = auth()->user();
        $this->authorize('view', $user);

        $trainingTypes = TrainingType::all();

        return view('pages.setup.trainingTypesShow', ['user' => $user, 'trainingTypes' => $trainingTypes]);
    }

    public function insuranceShow()
    {
        $user = auth()->user();
        $this->authorize('view', $user);

        return view('pages.setup.insuranceShow', ['user' => $user]);
    }

    public function paymentShow()
    {
        $user = auth()->user();
        $this->authorize('view', $user);

        return view('pages.setup.paymentShow',  ['user' => $user]);
    }
}
