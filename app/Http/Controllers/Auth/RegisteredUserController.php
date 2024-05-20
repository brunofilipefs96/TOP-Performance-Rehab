<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'digits:9'],
            'gender' => ['required', 'string', 'max:50'],
            'nif' => ['required', 'string', 'digits:9'],
            'cc_number' => ['required', 'string', 'max:9'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->gender === 'other') {
            $request->merge(['gender' => $request->other_gender]);
        }

        $user = User::create([
            'full_name' => $request->full_name,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'nif' => $request->nif,
            'cc_number' => $request->cc_number,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->sync(4);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
