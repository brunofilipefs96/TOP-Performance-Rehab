@php
    use Carbon\Carbon;
    $horarioInicioSemanal = setting('horario_inicio_semanal', '06:00');
    $horarioFimSemanal = setting('horario_fim_semanal', '23:59');
    $horarioInicioSabado = setting('horario_inicio_sabado', '08:00');
    $horarioFimSabado = setting('horario_fim_sabado', '18:00');
    $duracao = Carbon::parse($training->start_date)->diffInMinutes(Carbon::parse($training->end_date));
@endphp

<div class="container mx-auto mt-10 mb-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('trainings.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="mt-10 text-center">
                <h1 class="mb-6 dark:text-lime-400 font-semibold text-gray-800">Editar Treino</h1>
            </div>
            @if ($trainingTypes->isEmpty() || $rooms->isEmpty() || $personalTrainers->isEmpty())
                <div class="mb-4 dark:text-white text-gray-800">
                    <p class="mb-2">Para editar um treino, precisa de adicionar pelo menos um tipo de treino, uma sala e um personal trainer.</p>
                    @if ($trainingTypes->isEmpty())
                        <a href="{{ route('training_types.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Adicionar Tipo de Treino</a>
                    @endif
                    @if ($rooms->isEmpty())
                        <a href="{{ route('rooms.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Adicionar Sala</a>
                    @endif
                    @if ($personalTrainers->isEmpty())
                        <p class="bg-red-500 text-white py-2 px-4 rounded-md shadow-sm">Nenhum personal trainer disponível. Por favor, adicione um personal trainer.</p>
                    @endif
                </div>
            @else
                <form method="POST" action="{{ route('trainings.update', $training) }}" id="update-form">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="training_type_id" class="block dark:text-white text-gray-800">Tipo de Treino</label>
                        <select name="training_type_id" id="training_type_id" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                            @foreach ($trainingTypes as $type)
                                <option value="{{ $type->id }}" {{ old('training_type_id', $training->training_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('training_type_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="room_id" class="block dark:text-white text-gray-800">Sala</label>
                        <select name="room_id" id="room_id" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $training->room_id) == $room->id ? 'selected' : '' }} data-capacity="{{ $room->capacity }}">{{ $room->name }} - Capacidade: {{ $room->capacity }}</option>
                            @endforeach
                        </select>
                        @error('room_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="personal_trainer_id" class="block dark:text-white text-gray-800">Personal Trainer</label>
                        @if (Auth::user()->hasRole('admin'))
                            <select name="personal_trainer_id" id="personal_trainer_id" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                                @foreach ($personalTrainers as $trainer)
                                    <option value="{{ $trainer->id }}" {{ old('personal_trainer_id', $training->personal_trainer_id) == $trainer->id ? 'selected' : '' }}>{{ $trainer->firstLastName() }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="personal_trainer_id" id="personal_trainer_id" value="{{ auth()->user()->id }}">
                            <input type="text" value="{{ auth()->user()->firstLastName() }}" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white" readonly>
                        @endif
                        @error('personal_trainer_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="start_date" class="block dark:text-white text-gray-800">Data</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($training->start_date)->format('Y-m-d')) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        @error('start_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span id="start_date_error" class="text-red-500 text-sm"></span>
                    </div>
                    <div class="mb-4">
                        <label for="start_time" class="block dark:text-white text-gray-800">Hora de Início</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($training->start_date)->format('H:i')) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span class="text-sm text-gray-600 dark:text-gray-400">Horário permitido: {{ $horarioInicioSemanal }} - {{ $horarioFimSemanal }} (Seg-Sex) / {{ $horarioInicioSabado }} - {{ $horarioFimSabado }} (Sáb)</span>
                        <span id="start_time_error" class="text-red-500 text-sm"></span>
                    </div>
                    <div class="mb-4">
                        <label for="duration" class="block dark:text-white text-gray-800">Duração</label>
                        <select name="duration" id="duration" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                            <option value="30" {{ $duracao == 30 ? 'selected' : '' }}>30 minutos</option>
                            <option value="45" {{ $duracao == 45 ? 'selected' : '' }}>45 minutos</option>
                            <option value="60" {{ $duracao == 60 ? 'selected' : '' }}>60 minutos</option>
                            <option value="75" {{ $duracao == 75 ? 'selected' : '' }}>75 minutos</option>
                            <option value="90" {{ $duracao == 90 ? 'selected' : '' }}>90 minutos</option>
                        </select>
                        @error('duration')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span id="duration_error" class="text-red-500 text-sm"></span>
                    </div>
                    <div class="flex justify-end gap-2 mt-10">
                        <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm" onclick="showConfirmationModal()">Atualizar</button>
                    </div>
                </form>
                <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                    <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende atualizar?</h2>
                        <p class="mb-4 dark:text-lime-200 text-gray-800">Poderá reverter isso!</p>
                        <div class="flex justify-end gap-4">
                            <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                            <button id="confirm-button" class="bg-blue-500 hover:bg-blue-400 dark:bg-lime-500 text-white px-4 py-2 rounded-md dark:hover:bg-lime-400" onclick="confirmarAtualizacao()">Atualizar</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function showConfirmationModal() {
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    function confirmarAtualizacao() {
        document.getElementById('update-form').submit();
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start_date');
        const startTimeInput = document.getElementById('start_time');
        const durationInput = document.getElementById('duration');
        const startDateError = document.getElementById('start_date_error');
        const startTimeError = document.getElementById('start_time_error');
        const durationError = document.getElementById('duration_error');

        const closedDates = @json($closures); // Passar os dias fechados do backend para o frontend

        const form = document.getElementById('update-form');

        form.addEventListener('submit', function (event) {
            const startDate = new Date(startDateInput.value);
            const startTime = new Date(startDateInput.value + 'T' + startTimeInput.value);
            const duration = parseInt(durationInput.value);
            const endTime = new Date(startTime.getTime() + duration * 60000);

            const horarioInicioSemanal = new Date(startDateInput.value + 'T' + '{{ $horarioInicioSemanal }}');
            const horarioFimSemanal = new Date(startDateInput.value + 'T' + '{{ $horarioFimSemanal }}');
            const horarioInicioSabado = new Date(startDateInput.value + 'T' + '{{ $horarioInicioSabado }}');
            const horarioFimSabado = new Date(startDateInput.value + 'T' + '{{ $horarioFimSabado }}');

            const dayOfWeek = startDate.getDay();
            const selectedDate = startDateInput.value;
            let isValid = true;

            if (closedDates.includes(selectedDate)) {
                startDateError.innerText = 'O ginásio está fechado nesta data.';
                isValid = false;
            } else {
                startDateError.innerText = '';
            }

            if ((dayOfWeek >= 1 && dayOfWeek <= 5) && (startTime < horarioInicioSemanal || startTime > horarioFimSemanal || endTime > horarioFimSemanal)) {
                startTimeError.innerText = 'A hora de início deve estar entre ' + '{{ $horarioInicioSemanal }}' + ' e ' + '{{ $horarioFimSemanal }}' + ' nos dias de semana.';
                isValid = false;
            } else if (dayOfWeek == 6 && (startTime < horarioInicioSabado || startTime > horarioFimSabado || endTime > horarioFimSabado)) {
                startTimeError.innerText = 'A hora de início deve estar entre ' + '{{ $horarioInicioSabado }}' + ' e ' + '{{ $horarioFimSabado }}' + ' no sábado.';
                isValid = false;
            } else {
                startTimeError.innerText = '';
            }

            if (duration < 30) {
                durationError.innerText = 'A duração do treino deve ser de pelo menos 30 minutos.';
                isValid = false;
            } else if (duration > 90) {
                durationError.innerText = 'A duração do treino não pode exceder 90 minutos.';
                isValid = false;
            } else {
                durationError.innerText = '';
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>
