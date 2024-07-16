<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function changeRole()
    {
        $user = Auth::user();

        if ($user->roles->count() > 1) {
            $currentRole = $user->active_role_id;
            $otherRole = $user->roles->where('id', '!=', $currentRole)->first();

            if ($otherRole) {
                $user->active_role_id = $otherRole->id;
                $user->save();
            }
        }

        return redirect()->route('dashboard');
    }

}
