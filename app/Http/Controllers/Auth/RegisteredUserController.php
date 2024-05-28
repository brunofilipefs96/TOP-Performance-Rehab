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
            'phone_number' => ['required', 'string', 'digits:9', 'unique:'.User::class],
            'gender' => ['required', 'string', 'max:50'],
            'nif' => ['required', 'string', 'digits:9', 'unique:'.User::class],
            'cc_number' => ['required', 'string', 'digits:9', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'name' => ['required', 'string', 'max:255'],   //Name from Address
            'street' => ['required', 'string', 'max:255'],         //Street from Address
            'city' => ['required', 'string', 'max:255'],           //City from Address
            'postal_code' => [                                     //Postal Code from Address
                'required',
                'string',
                'max:8',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d{4}-\d{3}$/', $value)) {
                        $fail('O campo ' . $attribute . ' deve estar no formato xxxx-xxx.');
                    }
                },
            ],
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

        $user->addresses()->create([
            'user_id' => $user->id,
            'name' => $request->name,
            'street' => $request->street,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
