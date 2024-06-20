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
    public function view(User $user, Training $training): Response
    {
        $currentDateTime = Carbon::now()->setTimezone('Europe/Lisbon');
        $trainingStartDateTime = Carbon::parse($training->start_date);

        if ($currentDateTime->lt($trainingStartDateTime)) {
            return Response::allow();
        }

        if ($user->hasRole('admin') || $user->id === $training->personal_trainer_id || $training->users()->contains($user)) {
            return Response::allow();
        }

        return Response::deny('Não tem permissão para visualizar este treino.');
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
    public function update(User $user, Training $training): Response
    {
        $currentDateTime = Carbon::now()->setTimezone('Europe/Lisbon');
        $trainingStartDateTime = Carbon::parse($training->start_date);

        if (($user->id === $training->personal_trainer_id || $user->hasRole('admin')) &&
            $currentDateTime->lt($trainingStartDateTime)) {
            return Response::allow();
        }

        return Response::deny('Não pode editar este treino');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Training $training): Response
    {
        $currentDateTime = Carbon::now()->setTimezone('Europe/Lisbon');
        $trainingStartDateTime = Carbon::parse($training->start_date);

        if (($user->id === $training->personal_trainer_id || $user->hasRole('admin')) &&
            $currentDateTime->lt($trainingStartDateTime)) {
            return Response::allow();
        }

        return Response::deny('Não pode apagar este treino.');
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

    /**
     * Determine whether the user can delete multiple models.
     */
    public function multiDelete(User $user, array $trainingIds): Response
    {
        $currentDateTime = Carbon::now()->setTimezone('Europe/Lisbon');
        $trainings = Training::whereIn('id', $trainingIds)->get();

        foreach ($trainings as $training) {
            $trainingStartDateTime = Carbon::parse($training->start_date);

            if (!($user->hasRole('admin') || ($user->id === $training->personal_trainer_id && $currentDateTime->lt($trainingStartDateTime)))) {
                return Response::deny('Você não tem permissão para remover um ou mais treinos selecionados.');
            }
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can enroll in the model.
     */
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

        return Response::deny('Não pode inscrever-se neste treino');
    }
}
