<?php

namespace App\Http\Controllers;

use App\Models\Role;
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

        $roles = Role::whereNotIn('name', $user->roles->pluck('name'))->get();

        return view('pages.users.show', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        Storage::deleteDirectory('public/images/users/' . $user->id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function storeRole(Request $request, User $user)
    {
        $role = Role::where('name', $request->input('role'))->first();

        if ($role->name === 'admin') {
            $user->roles()->detach();
            $user->roles()->attach($role);
        } else {
            $clientRole = Role::where('name', 'client')->first();

            if ($user->roles->isEmpty() && $role->name != 'client') {
                $user->roles()->attach($clientRole);
            }

            if ($user->roles->count() < 2 && !$user->roles->contains('name', $role->name)) {
                $user->roles()->attach($role);
            } else {
                return redirect()->route('users.show', $user)->with('error', 'Usuário já possui dois cargos.');
            }
        }

        return redirect()->route('users.show', $user)->with('success', 'Cargo adicionado com sucesso.');
    }

    public function destroyRole(User $user, Role $role)
    {
        if ($role->name === 'client') {
            return redirect()->route('users.show', $user)->with('error', 'Não é possível remover o cargo de Cliente.');
        }

        if ($role->name === 'admin') {
            $clientRole = Role::where('name', 'client')->first();
            $user->roles()->detach($role);
            $user->roles()->attach($clientRole);
        }else{
            $user->roles()->detach($role);
        }

        return redirect()->route('users.show', $user)->with('success', 'Cargo removido com sucesso.');
    }
}
