<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('pages.users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        return view('pages.users.show', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

}
