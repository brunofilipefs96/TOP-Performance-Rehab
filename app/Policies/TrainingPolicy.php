<?php

namespace App\Policies;

use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class TrainingPolicy
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
    public function view(User $user, Training $training): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('personal_trainer') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Training $training): bool
    {
        return $user->id === $training->personal_trainer_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Training $training): bool
    {
        return $user->id === $training->personal_trainer_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Training $training): bool
    {
        return $user->id === $training->personal_trainer_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Training $training): bool
    {
        return $user->id === $training->personal_trainer_id || $user->hasRole('admin');
    }

    public function enroll(User $user, Training $training): Response
    {
        $currentDateTime = Carbon::now()->setTimezone('Europe/Lisbon');
        $trainingDateTime = Carbon::parse($training->start_date);

        if ($training->users()->count() < $training->max_students &&
            !$training->users()->contains($user) &&
            $training->personalTrainer->id !== $user->id &&
            $currentDateTime->lt($trainingDateTime)) {
            return Response::allow();
        }

        return Response::deny('Você não pode se inscrever neste treino.');
    }

}
