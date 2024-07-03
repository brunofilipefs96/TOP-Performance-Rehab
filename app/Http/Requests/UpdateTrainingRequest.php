<?php

namespace App\Http\Requests;

use App\Models\Room;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingRequest extends FormRequest
{
    /**
     * Get the validation rules que se aplicam ao request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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

            $this->validatePersonalTrainerAvailability($validator, $startDate, $endDate);
            $this->validateRoomCapacity($validator, $startDate, $endDate);

            if (Carbon::today()->eq(Carbon::parse($this->start_date))) {
                if ($startDate->lt($now)) {
                    $validator->errors()->add('start_time', 'A hora de início deve ser posterior à hora atual para o dia de hoje.');
                }
            }

            $horarioInicio = Carbon::createFromFormat('Y-m-d H:i', $this->start_date . ' ' . setting('horario_inicio', '06:00'));
            $horarioFim = Carbon::createFromFormat('Y-m-d H:i', $this->start_date . ' ' . setting('horario_fim', '23:59'));

            if ($startDate->lt($horarioInicio) || $startDate->gt($horarioFim)) {
                $validator->errors()->add('start_time', 'A hora de início deve estar entre ' . setting('horario_inicio', '06:00') . ' e ' . setting('horario_fim', '23:59') . '.');
            }

            if ($endDate->gt($horarioFim)) {
                $validator->errors()->add('end_time', 'O treino deve terminar antes das ' . setting('horario_fim', '23:59') . '.');
            }

            if ($duration < 30) {
                $validator->errors()->add('duration', 'A duração do treino deve ser de pelo menos 30 minutos.');
            }

            if ($duration > 90) {
                $validator->errors()->add('duration', 'A duração do treino não pode exceder 90 minutos.');
            }

            $currentEnrolled = $this->route('training')->users()->count();
            if ($this->max_students < $currentEnrolled) {
                $validator->errors()->add('max_students', 'O número máximo de alunos não pode ser menor do que o número de alunos já inscritos.');
            }
        });
    }

    protected function validateRoomCapacity($validator, $startDate, $endDate)
    {
        $roomId = $this->room_id;
        $maxStudents = $this->max_students;

        $conflictingTrainings = Training::where('room_id', $roomId)
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
}
