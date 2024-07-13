<?php

namespace App\Http\Requests;

use App\Models\GymClosure;
use App\Models\Room;
use App\Models\Training;
use App\Models\FreeTraining;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'repeat' => filter_var($this->repeat, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'training_type_id' => 'required|exists:training_types,id',
            'room_id' => 'required|exists:rooms,id',
            'max_students' => 'required|integer|min:1',
            'personal_trainer_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:30|max:90',
            'repeat' => 'nullable|boolean',
            'repeat_until' => 'nullable|required_if:repeat,true|date|after:start_date',
            'days_of_week' => 'nullable|array|required_if:repeat,true',
            'days_of_week.*' => 'in:1,2,3,4,5,6',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d H:i', $this->start_date . ' ' . $this->start_time);
                $duration = (int)$this->duration;
                $endDate = $startDate->copy()->addMinutes($duration);
            } catch (\Exception $e) {
                $validator->errors()->add('start_date', 'A data ou hora de início é inválida.');
                return;
            }

            $dayOfWeek = $startDate->dayOfWeek;
            $closureDates = GymClosure::pluck('closure_date')->toArray();

            if (in_array($startDate->toDateString(), $closureDates)) {
                $validator->errors()->add('start_date', 'Os treinos não podem ser agendados em dias que o ginásio está fechado.');
            }

            $horarioInicioSemanal = setting('horario_inicio_semanal', '06:00');
            $horarioFimSemanal = setting('horario_fim_semanal', '23:30');
            $horarioInicioSabado = setting('horario_inicio_sabado', '08:00');
            $horarioFimSabado = setting('horario_fim_sabado', '18:00');

            if (!$this->isHorarioPermitido($startDate, $endDate, $dayOfWeek, $horarioInicioSemanal, $horarioFimSemanal, $horarioInicioSabado, $horarioFimSabado)) {
                $validator->errors()->add('start_time', 'O treino deve estar dentro do horário permitido.');
            }

            if (Carbon::today()->eq($startDate->copy()->startOfDay()) && $startDate->lt(Carbon::now())) {
                if (!$this->has('repeat') || !$this->repeat) {
                    $validator->errors()->add('start_time', 'A hora de início deve ser posterior à hora atual para o dia de hoje.');
                }
            }

            if ($this->has('repeat') && $this->repeat) {
                if (!$this->has('days_of_week') || empty($this->days_of_week)) {
                    $validator->errors()->add('days_of_week', 'Por favor, selecione pelo menos um dia da semana para repetição.');
                }

                try {
                    $repeatUntil = Carbon::parse($this->repeat_until);
                } catch (\Exception $e) {
                    $validator->errors()->add('repeat_until', 'A data de repetição final é inválida.');
                    return;
                }

                if ($repeatUntil->lt($startDate)) {
                    $validator->errors()->add('repeat_until', 'A data de repetição final deve ser posterior à data de início.');
                }
            }

            if (!$this->validateRoomCapacity($startDate, $endDate, $this->room_id, $this->max_students)) {
                $validator->errors()->add('room_id', 'A capacidade da sala não permite este treino.');
            }

            if (!$this->validatePersonalTrainerAvailability($startDate, $endDate, $this->personal_trainer_id)) {
                $validator->errors()->add('personal_trainer_id', 'O Personal Trainer não está disponível neste horário.');
            }

            if (!$this->validateGymCapacity($startDate, $endDate, $this->max_students)) {
                $validator->errors()->add('max_students', 'A capacidade do ginásio não permite este treino.');
            }
        });
    }

    private function isHorarioPermitido($startDate, $endDate, $dayOfWeek, $horarioInicioSemanal, $horarioFimSemanal, $horarioInicioSabado, $horarioFimSabado)
    {
        $startTime = $startDate->format('H:i');
        $endTime = $endDate->format('H:i');

        if ($dayOfWeek >= Carbon::MONDAY && $dayOfWeek <= Carbon::FRIDAY) {
            if ($startTime < $horarioInicioSemanal || $endTime > $horarioFimSemanal || $endDate->isNextDay($startDate)) {
                return false;
            }
        } elseif ($dayOfWeek == Carbon::SATURDAY) {
            if ($startTime < $horarioInicioSabado || $endTime > $horarioFimSabado || $endDate->isNextDay($startDate)) {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    public function passesValidation($startDate, $endDate, $roomId, $personalTrainerId, $maxStudents)
    {
        return $this->isHorarioPermitido(
                $startDate,
                $endDate,
                $startDate->dayOfWeek,
                setting('horario_inicio_semanal', '06:00'),
                setting('horario_fim_semanal', '23:30'),
                setting('horario_inicio_sabado', '08:00'),
                setting('horario_fim_sabado', '18:00')
            ) && $this->validateRoomCapacity($startDate, $endDate, $roomId, $maxStudents)
            && $this->validatePersonalTrainerAvailability($startDate, $endDate, $personalTrainerId)
            && $this->validateGymCapacity($startDate, $endDate, $maxStudents);
    }

    protected function validateRoomCapacity($startDate, $endDate, $roomId, $maxStudents)
    {
        $conflictingTrainings = Training::where('room_id', $roomId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $endDate);
                    });
            })
            ->get();

        $room = Room::find($roomId);
        $occupiedCapacity = $conflictingTrainings->sum('max_students');
        $availableCapacity = $room->capacity - $occupiedCapacity;

        return $maxStudents <= $availableCapacity;
    }

    protected function validatePersonalTrainerAvailability($startDate, $endDate, $personalTrainerId)
    {
        $conflictingTrainings = Training::where('personal_trainer_id', $personalTrainerId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $endDate);
                    });
            })
            ->get();

        return $conflictingTrainings->isEmpty();
    }

    protected function validateGymCapacity($startDate, $endDate, $maxStudents)
    {
        $totalCapacity = setting('capacidade_maxima');

        $regularTrainingOccupancy = Training::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<', $startDate)
                        ->where('end_date', '>', $endDate);
                });
        })->sum('max_students');

        $freeTrainingOccupancy = FreeTraining::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<', $startDate)
                        ->where('end_date', '>', $endDate);
                });
        })->sum('max_students');

        $occupiedCapacity = $regularTrainingOccupancy + $freeTrainingOccupancy;
        $availableCapacity = $totalCapacity - $occupiedCapacity;

        return $occupiedCapacity + $maxStudents <= $totalCapacity;
    }
}
