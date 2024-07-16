<?php

namespace App\Http\Requests;

use App\Models\Room;
use App\Models\Training;
use App\Models\FreeTraining;
use App\Models\GymClosure;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'training_type_id.required' => 'O tipo de treino é obrigatório.',
            'training_type_id.exists' => 'O tipo de treino selecionado é inválido.',
            'room_id.required' => 'A sala é obrigatória.',
            'room_id.exists' => 'A sala selecionada é inválida.',
            'max_students.required' => 'O número máximo de alunos é obrigatório.',
            'max_students.integer' => 'O número máximo de alunos deve ser um número inteiro.',
            'max_students.min' => 'O número máximo de alunos deve ser pelo menos 1.',
            'personal_trainer_id.exists' => 'O personal trainer selecionado é inválido.',
            'start_date.required' => 'A data de início é obrigatória.',
            'start_date.date' => 'A data de início deve ser uma data válida.',
            'start_date.after_or_equal' => 'A data de início deve ser hoje ou uma data futura.',
            'start_time.required' => 'A hora de início é obrigatória.',
            'start_time.date_format' => 'A hora de início deve estar no formato HH:mm.',
            'duration.required' => 'A duração é obrigatória.',
            'duration.integer' => 'A duração deve ser um número inteiro.',
            'duration.min' => 'A duração mínima é de 30 minutos.',
            'duration.max' => 'A duração máxima é de 90 minutos.',
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

            $duration = (int)$this->duration;
            $endDate = $startDate->copy()->addMinutes($duration);
            $now = Carbon::now('Europe/Lisbon');
            $dayOfWeek = $startDate->dayOfWeek;

            // Verificação de dias fechados
            $closureDates = GymClosure::pluck('closure_date')->toArray();
            if (in_array($startDate->toDateString(), $closureDates)) {
                $validator->errors()->add('start_date', 'Os treinos não podem ser agendados em dias que o ginásio está fechado.');
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

            $training = $this->route('training');

            if ($training->users()->count() > 0) {
                $validator->errors()->add('max_students', 'Não é possível editar um treino com alunos inscritos.');
                return;
            }

            $this->validateRoomCapacity($validator, $startDate, $endDate, $training);
            $this->validatePersonalTrainerAvailability($validator, $startDate, $endDate);
            $this->validateGymCapacity($validator, $startDate, $endDate, $this->max_students, $training);

            if (Carbon::today()->eq(Carbon::parse($this->start_date))) {
                if ($startDate->lt($now)) {
                    $validator->errors()->add('start_time', 'A hora de início deve ser posterior à hora atual para o dia de hoje.');
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

    protected function validateRoomCapacity($validator, $startDate, $endDate, $training)
    {
        $roomId = $this->room_id;
        $maxStudents = $this->max_students;

        $conflictingTrainings = Training::where('room_id', $roomId)
            ->where('id', '!=', $training->id)
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
        $availableCapacity = $room->capacity - $occupiedCapacity + $training->max_students;

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
            ->where('id', '!=', $this->route('training')->id)
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

    protected function validateGymCapacity($validator, $startDate, $endDate, $maxStudents, $training)
    {
        $totalCapacity = setting('capacidade_maxima');

        $regularTrainingOccupancy = Training::where('id', '!=', $training->id)
            ->where(function ($query) use ($startDate, $endDate) {
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
        $availableCapacity = $totalCapacity - $occupiedCapacity + $training->max_students;

        if ($occupiedCapacity + $maxStudents > $totalCapacity) {
            if ($availableCapacity <= 0) {
                $validator->errors()->add('max_students', 'A capacidade do ginásio para o horário selecionado está lotada.');
            } else {
                $validator->errors()->add('max_students', "A capacidade máxima atual do ginásio para este horário é {$availableCapacity}. Tente agendar noutro horário ou com menos alunos.");
            }
        }
    }
}
