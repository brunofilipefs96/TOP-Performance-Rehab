<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::with('roles')->orderBy('id', 'desc')->paginate(12);
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
        Storage::deleteDirectory('public/images/users/' . $user->id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

}
