<?php

namespace App\Policies;

use App\Models\Insurance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InsurancePolicy
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
    public function view(User $user, Insurance $insurance): bool
    {
        return $user->id == $insurance->membership->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->membership->insurance !== null) {
            return !$user->membership->insurance->exists();
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Insurance $insurance): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Insurance $insurance): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Insurance $insurance): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Insurance $insurance): bool
    {
        return $user->hasRole('admin');
    }
}
