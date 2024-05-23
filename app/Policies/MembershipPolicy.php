<?php

namespace App\Policies;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MembershipPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Membership $membership): bool
    {
        return $user->id === $membership->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Membership $membership): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Membership $membership): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Membership $membership): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Membership $membership): bool
    {
        return $user->hasRole('admin');
    }


    public function form(User $user): bool
    {
        return $user->hasRole('admin');    // Verificar se o Dono do Membership é o user que quer preencher o formulário
    }
}
