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
        return $user->hasRole('personal_trainer') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Training $training): Response
    {
        if ($this->canModifyTraining($user, $training)) {
            return Response::allow();
        }

        return Response::deny('Não pode editar este treino');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Training $training): bool
    {
        return $user->hasRole('admin') || $user->id === $training->personal_trainer_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Training $training): bool
    {
        return $user->hasRole('admin') || $user->id === $training->personal_trainer_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Training $training): bool
    {
        return $user->hasRole('admin') || $user->id === $training->personal_trainer_id;
    }

    /**
     * Determine whether the user can delete multiple models.
     */
    public function multiDelete(User $user, array $trainingIds): Response
    {
        $currentDateTime = Carbon::now();
        $trainings = Training::whereIn('id', $trainingIds)->get();

        foreach ($trainings as $training) {
            if (!$this->canModifyTraining($user, $training, $currentDateTime)) {
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
        $currentDateTime = Carbon::now();
        $trainingDateTime = Carbon::parse($training->start_date);

        if (!$user->membership || $user->membership->status->name !== 'active') {
            return Response::deny('Necessita de uma matrícula ativa para se inscrever em qualquer treino.');
        }

        if ($training->users()->where('user_id', $user->id)->doesntExist() &&
            $training->users()->count() < $training->max_students &&
            $training->personal_trainer_id !== $user->id &&
            $currentDateTime->lt($trainingDateTime)) {
            return Response::allow();
        }

        return Response::deny('Não pode inscrever-se neste treino');
    }

    public function cancel(User $user, Training $training): Response
    {
        $isUserEnrolled = $training->users()->where('user_id', $user->id)->exists();
        $currentDateTime = Carbon::now();
        $trainingStartDateTime = Carbon::parse($training->start_date);

        if ($isUserEnrolled && $currentDateTime->lt($trainingStartDateTime)) {
            return Response::allow();
        }

        return Response::deny('Não tem permissão para cancelar a inscrição neste treino.');
    }



    public function markPresence(User $user, Training $training): Response
    {
        $currentDateTime = Carbon::now();
        $trainingStartDateTime = Carbon::parse($training->start_date);

        if (($user->hasRole('admin') || $user->id === $training->personal_trainer_id) && $currentDateTime->gte($trainingStartDateTime)) {
            return Response::allow();
        }

        return Response::deny('Não tem permissão para marcar presenças para este treino.');
    }

    /**
     * Helper function to determine if the user can modify a training.
     */
    private function canModifyTraining(User $user, Training $training, $currentDateTime = null): bool
    {
        $currentDateTime = $currentDateTime ?: Carbon::now();
        $trainingStartDateTime = Carbon::parse($training->start_date);

        return ($user->id === $training->personal_trainer_id || $user->hasRole('admin')) &&
            $currentDateTime->lte($trainingStartDateTime);
    }
}
