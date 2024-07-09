<?php

namespace App\Policies;

use App\Models\FreeTraining;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class FreeTrainingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FreeTraining $training): Response
    {
        $currentWeekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $trainingStartDateTime = Carbon::parse($training->start_date);

        if ($trainingStartDateTime->gte($currentWeekStart) || $user->hasRole('admin') || $user->id === $training->personal_trainer_id || $training->users->contains($user)) {
            return Response::allow();
        }

        return Response::deny('Não tem permissão para visualizar este treino.');
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
    public function update(User $user, FreeTraining $freeTraining): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FreeTraining $freeTraining): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FreeTraining $freeTraining): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FreeTraining $freeTraining): bool
    {
        return $user->hasRole('admin');
    }
}
