<?php

namespace App\Http\Requests;

use App\Models\Room;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRequest extends FormRequest
{
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
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d H:i', $this->start_date . ' ' . $this->start_time);
            } catch (\Exception $e) {
                $validator->errors()->add('start_date', 'A data de início é inválida.');
                $validator->errors()->add('start_time', 'A hora de início é inválida.');
                return;
            }

            $duration = (int) $this->duration;
            $endDate = $startDate->copy()->addMinutes($duration);
            $now = Carbon::now('Europe/Lisbon');
            $dayOfWeek = $startDate->dayOfWeek;

            if ($startDate->isSunday()) {
                $validator->errors()->add('start_date', 'Os treinos não podem ser agendados aos domingos.');
            }

            $horarioInicioSemanal = setting('horario_inicio_semanal', '06:00');
            $horarioFimSemanal = setting('horario_fim_semanal', '23:59');
            $horarioInicioSabado = setting('horario_inicio_sabado', '08:00');
            $horarioFimSabado = setting('horario_fim_sabado', '18:00');

            $startTime = $startDate->format('H:i');
            $endTime = $endDate->format('H:i');

            if ($dayOfWeek >= Carbon::MONDAY && $dayOfWeek <= Carbon::FRIDAY) {
                if ($startTime < $horarioInicioSemanal || $startTime > $horarioFimSemanal) {
                    $validator->errors()->add('start_time', 'A hora de início deve estar entre ' . $horarioInicioSemanal . ' e ' . $horarioFimSemanal . ' nos dias de semana.');
                }
                if ($endTime > $horarioFimSemanal) {
                    $validator->errors()->add('end_time', 'O treino deve terminar antes das ' . $horarioFimSemanal . ' nos dias de semana.');
                }
            } elseif ($dayOfWeek == Carbon::SATURDAY) {
                if ($startTime < $horarioInicioSabado || $startTime > $horarioFimSabado) {
                    $validator->errors()->add('start_time', 'A hora de início deve estar entre ' . $horarioInicioSabado . ' e ' . $horarioFimSabado . ' no sábado.');
                }
                if ($endTime > $horarioFimSabado) {
                    $validator->errors()->add('end_time', 'O treino deve terminar antes das ' . $horarioFimSabado . ' no sábado.');
                }
            }

            $this->validatePersonalTrainerAvailability($validator, $startDate, $endDate);
            $this->validateRoomCapacity($validator, $startDate, $endDate);
            $this->validateGymCapacity($validator, $startDate, $endDate, $this->max_students);

            if (Carbon::today()->eq(Carbon::parse($this->start_date))) {
                if ($startDate->lt($now)) {
                    if (!$this->has('repeat') || !$this->repeat) {
                        $validator->errors()->add('start_time', 'A hora de início deve ser posterior à hora atual para o dia de hoje.');
                    }
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

                $validDays = collect($this->days_of_week)->map(function ($day) use ($startDate, $repeatUntil) {
                    return $startDate->copy()->next(Carbon::SUNDAY + $day)->lte($repeatUntil);
                });

                if (!$validDays->contains(true)) {
                    $validator->errors()->add('days_of_week', 'Os dias da semana selecionados não estão dentro do intervalo de repetição.');
                }
            }

            if ($duration < 30) {
                $validator->errors()->add('duration', 'A duração do treino deve ser de pelo menos 30 minutos.');
            }

            if ($duration > 90) {
                $validator->errors()->add('duration', 'A duração do treino não pode exceder 90 minutos.');
            }
        });
    }

    protected function validateRoomCapacity($validator, $startDate, $endDate)
    {
        $roomId = $this->room_id;
        $maxStudents = $this->max_students;

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

        if ($maxStudents > $availableCapacity) {
            if ($availableCapacity <= 0) {
                $validator->errors()->add('max_students', 'A capacidade desta sala para o horário selecionado está lotada.');
            } else {
                $validator->errors()->add('max_students', "A capacidade máxima atual da sala para este horário é {$availableCapacity}. Tente agendar noutro horário ou então com menos alunos.");
            }
        }
    }

    protected function validatePersonalTrainerAvailability($validator, $startDate, $endDate)
    {
        $personalTrainerId = $this->personal_trainer_id;

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

        if ($conflictingTrainings->isNotEmpty()) {
            $validator->errors()->add('personal_trainer_id', 'O Personal Trainer selecionado já possui um treino marcado no horário selecionado.');
        }
    }

    protected function validateGymCapacity($validator, $startDate, $endDate, $maxStudents)
    {
        $totalCapacity = setting('capacidade_maxima');
        $freeTrainingPercentage = setting('percentagem_aulas_livres');
        $freeTrainingCapacity = ceil($totalCapacity * ($freeTrainingPercentage / 100));
        $maxRegularTrainingCapacity = $totalCapacity - $freeTrainingCapacity;

        $regularTrainingOccupancy = Training::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<', $startDate)
                        ->where('end_date', '>', $endDate);
                });
        })->sum('max_students');

        if ($regularTrainingOccupancy + $maxStudents > $maxRegularTrainingCapacity) {
            $availableCapacity = $maxRegularTrainingCapacity - $regularTrainingOccupancy;
            if ($availableCapacity <= 0) {
                $validator->errors()->add('max_students', 'A capacidade do ginásio para treinos acompanhados no horário selecionado está lotada.');
            } else {
                $validator->errors()->add('max_students', "A capacidade máxima atual do ginásio para este horário é {$availableCapacity}. Tente agendar noutro horário ou com menos alunos.");
            }
        }
    }
}
