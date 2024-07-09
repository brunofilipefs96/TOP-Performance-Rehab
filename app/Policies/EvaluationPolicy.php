<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EvaluationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('personal_trainer') || $user->membership->status_id == 2;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Evaluation $evaluation): bool
    {
        return $user->hasRole('admin') || $user->hasRole('personal_trainer') || $user->id == $evaluation->membership->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('personal_trainer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Evaluation $evaluation): bool
    {
        return $user->hasRole('admin') || $user->hasRole('personal_trainer');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Evaluation $evaluation): bool
    {
        return $user->hasRole('admin') || $user->hasRole('personal_trainer');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Evaluation $evaluation): bool
    {
        return $user->hasRole('admin') || $user->hasRole('personal_trainer');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Evaluation $evaluation): bool
    {
        return $user->hasRole('admin') || $user->hasRole('personal_trainer');
    }
}
