<?php

namespace App\Http\Requests;

use App\Models\FreeTraining;
use App\Models\Training;
use App\Models\GymClosure;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreFreeTrainingRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'max_students' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];

        if ($this->has('repeat')) {
            $rules['repeat_until'] = 'required|date|after_or_equal:start_date';
            $rules['days_of_week'] = 'required|array|min:1';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'max_students.required' => 'O campo máximo de alunos é obrigatório.',
            'max_students.integer' => 'O campo máximo de alunos deve ser um número inteiro.',
            'max_students.min' => 'O campo máximo de alunos deve ser pelo menos 1.',
            'start_date.required' => 'O campo data é obrigatório.',
            'start_date.date' => 'O campo data deve ser uma data válida.',
            'start_date.after_or_equal' => 'A data deve ser igual ou posterior à data atual.',
            'start_time.required' => 'O campo hora de início é obrigatório.',
            'start_time.date_format' => 'O campo hora de início não está em um formato válido.',
            'end_time.required' => 'O campo hora de fim é obrigatório.',
            'end_time.date_format' => 'O campo hora de fim não está em um formato válido.',
            'end_time.after' => 'O campo hora de fim deve ser posterior à hora de início.',
            'repeat_until.required' => 'O campo repetir até é obrigatório quando a repetição está marcada.',
            'repeat_until.date' => 'O campo repetir até deve ser uma data válida.',
            'repeat_until.after_or_equal' => 'O campo repetir até deve ser uma data igual ou posterior à data inicial.',
            'days_of_week.required' => 'Selecione pelo menos um dia da semana para a repetição.',
            'days_of_week.array' => 'O campo dias da semana deve ser um array.',
            'days_of_week.min' => 'Selecione pelo menos um dia da semana para a repetição.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $startDate = Carbon::createFromFormat('Y-m-d H:i', $this->start_date . ' ' . $this->start_time);
            $endDate = Carbon::createFromFormat('Y-m-d H:i', $this->start_date . ' ' . $this->end_time);
            $now = Carbon::now('Europe/Lisbon');
            $dayOfWeek = $startDate->dayOfWeek;

            if ($startDate->isToday() && $startDate->lt($now)) {
                $validator->errors()->add('start_time', 'A hora de início deve ser no futuro.');
            }

            $closureDates = GymClosure::pluck('closure_date')->toArray();
            if (in_array($startDate->toDateString(), $closureDates) && !$this->has('repeat')) {
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

            if ($this->has('repeat')) {
                $repeatUntilDate = Carbon::createFromFormat('Y-m-d', $this->repeat_until);
                $daysOfWeek = $this->days_of_week;
                $allDaysValid = false;

                foreach ($daysOfWeek as $dayOfWeek) {
                    $currentDate = $startDate->copy();
                    while ($currentDate->dayOfWeek !== (int)$dayOfWeek) {
                        $currentDate->addDay();
                    }

                    while ($currentDate->lessThanOrEqualTo($repeatUntilDate)) {
                        $horarioInicio = ($currentDate->dayOfWeek === Carbon::SATURDAY) ? $horarioInicioSabado : $horarioInicioSemanal;
                        $horarioFim = ($currentDate->dayOfWeek === Carbon::SATURDAY) ? $horarioFimSabado : $horarioFimSemanal;

                        $gymCapacityValid = $this->validateGymCapacity($currentDate->copy()->setTimeFromTimeString($startTime), $currentDate->copy()->setTimeFromTimeString($endTime), $this->max_students);
                        $uniqueTimesValid = $this->validateUniqueTimes($currentDate->copy()->setTimeFromTimeString($startTime), $currentDate->copy()->setTimeFromTimeString($endTime));

                        if ($gymCapacityValid && $uniqueTimesValid) {
                            $allDaysValid = true;
                            break;
                        }

                        $currentDate->addWeek();
                    }

                    if ($allDaysValid) {
                        break;
                    }
                }

                if (!$allDaysValid) {
                    $validator->errors()->add('start_time', 'Todos os blocos de 30 minutos no horário selecionado já possuem treinos livres em todos os dias selecionados.');
                }
            } else {
                $gymCapacityValid = $this->validateGymCapacity($startDate, $endDate, $this->max_students);
                $uniqueTimesValid = $this->validateUniqueTimes($startDate, $endDate);
                if (!$gymCapacityValid || !$uniqueTimesValid) {
                    $validator->errors()->add('start_time', 'Todos os blocos de 30 minutos no horário selecionado já possuem treinos livres.');
                }
            }
        });
    }

    protected function validateGymCapacity($startDate, $endDate, $maxStudents)
    {
        $totalCapacity = setting('capacidade_maxima');
        $duration = 30;
        $allSlotsFull = true;

        while ($startDate->lessThan($endDate)) {
            $blockEndDate = $startDate->copy()->addMinutes($duration);

            $regularTrainingOccupancy = Training::where(function ($query) use ($startDate, $blockEndDate) {
                $query->whereBetween('start_date', [$startDate, $blockEndDate])
                    ->orWhereBetween('end_date', [$startDate, $blockEndDate])
                    ->orWhere(function ($query) use ($startDate, $blockEndDate) {
                        $query->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $blockEndDate);
                    });
            })->sum('max_students');

            $freeTrainingOccupancy = FreeTraining::where(function ($query) use ($startDate, $blockEndDate) {
                $query->whereBetween('start_date', [$startDate, $blockEndDate])
                    ->orWhereBetween('end_date', [$startDate, $blockEndDate])
                    ->orWhere(function ($query) use ($startDate, $blockEndDate) {
                        $query->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $blockEndDate);
                    });
            })->sum('max_students');

            $availableCapacity = $totalCapacity - $regularTrainingOccupancy - $freeTrainingOccupancy;

            if ($maxStudents <= $availableCapacity) {
                $allSlotsFull = false;
                break; // Se encontrar um bloco com capacidade disponível, para o loop
            }

            $startDate->addMinutes($duration);
        }

        return !$allSlotsFull;
    }

    protected function validateUniqueTimes($startDate, $endDate)
    {
        $duration = 30;
        $allSlotsOccupied = true;

        while ($startDate->lessThan($endDate)) {
            $blockEndDate = $startDate->copy()->addMinutes($duration);

            $overlappingTrainings = FreeTraining::where(function ($query) use ($startDate, $blockEndDate) {
                $query->where(function ($query) use ($startDate, $blockEndDate) {
                    $query->where('start_date', '<=', $startDate)
                        ->where('end_date', '>', $startDate);
                })->orWhere(function ($query) use ($startDate, $blockEndDate) {
                    $query->where('start_date', '<', $blockEndDate)
                        ->where('end_date', '>=', $blockEndDate);
                })->orWhere(function ($query) use ($startDate, $blockEndDate) {
                    $query->where('start_date', '>=', $startDate)
                        ->where('start_date', '<', $blockEndDate);
                });
            })->exists();

            if (!$overlappingTrainings) {
                $allSlotsOccupied = false;
                break; // Se encontrar um bloco disponível, para o loop
            }

            $startDate->addMinutes($duration);
        }

        return !$allSlotsOccupied;
    }
}
