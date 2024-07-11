@php
    use Carbon\Carbon;
    $horarioInicioSemanal = setting('horario_inicio_semanal', '06:00');
    $horarioFimSemanal = setting('horario_fim_semanal', '23:59');
    $horarioInicioSabado = setting('horario_inicio_sabado', '08:00');
    $horarioFimSabado = setting('horario_fim_sabado', '18:00');
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
                <h1 class="mb-6 dark:text-lime-400 font-semibold text-gray-800">Criar Treino</h1>
            </div>
            @if ($trainingTypes->isEmpty() || $rooms->isEmpty() || $personalTrainers->isEmpty())
                <div class="mb-4 dark:text-white text-gray-800">
                    <p class="mb-2">Para criar um treino, precisa de adicionar pelo menos um tipo de treino, uma sala e um personal trainer.</p>
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
                <form method="POST" action="{{ route('trainings.store') }}" id="trainingForm">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block dark:text-white text-gray-800">Nome</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="training_type_id" class="block dark:text-white text-gray-800">Tipo de Treino</label>
                        <select name="training_type_id" id="training_type_id" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                            @foreach ($trainingTypes as $type)
                                <option value="{{ $type->id }}" {{ old('training_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
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
                                <option value="{{ $room->id }}" data-capacity="{{ $room->capacity }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }} - Capacidade: {{ $room->capacity }}</option>
                            @endforeach
                        </select>
                        @error('room_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="max_students" class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                        <input type="number" name="max_students" id="max_students" value="{{ old('max_students') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        @error('max_students')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="personal_trainer_id" class="block dark:text-white text-gray-800">Personal Trainer</label>
                        @if (Auth::user()->hasRole('admin'))
                            <select name="personal_trainer_id" id="personal_trainer_id" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                                @foreach ($personalTrainers as $trainer)
                                    <option value="{{ $trainer->id }}" {{ old('personal_trainer_id') == $trainer->id ? 'selected' : '' }}>{{ $trainer->firstLastName() }}</option>
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
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        @error('start_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span id="start_date_error" class="text-red-500 text-sm"></span>
                    </div>
                    <div class="mb-4">
                        <label for="start_time" class="block dark:text-white text-gray-800">Hora de Início</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span class="text-sm text-gray-600 dark:text-gray-400">Horário permitido: {{ $horarioInicioSemanal }} - {{ $horarioFimSemanal }} (Seg-Sex) / {{ $horarioInicioSabado }} - {{ $horarioFimSabado }} (Sáb)</span>
                        <span id="start_time_error" class="text-red-500 text-sm"></span>
                    </div>
                    <div class="mb-4">
                        <label for="duration" class="block dark:text-white text-gray-800">Duração</label>
                        <select name="duration" id="duration" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                            <option value="30">30 minutos</option>
                            <option value="45">45 minutos</option>
                            <option value="60">60 minutos</option>
                            <option value="75">75 minutos</option>
                            <option value="90">90 minutos</option>
                        </select>
                        @error('duration')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span id="duration_error" class="text-red-500 text-sm"></span>
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="repeat" id="repeat" class="form-checkbox h-5 w-5 text-blue-500 rounded dark:text-lime-500">
                        <label for="repeat" class="ml-2 block dark:text-white text-gray-800">Repetir Treino</label>
                    </div>
                    <div id="repeat-options" style="display: none;">
                        <div class="mb-4">
                            <label class="block dark:text-white text-gray-800"><i class="fa-solid fa-calendar-day mr-2"></i>Dias da Semana</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="flex items-center dark:text-gray-200 text-gray-800">
                                    <input type="checkbox" name="days_of_week[]" value="1" class="form-checkbox h-5 w-5 text-blue-500 rounded dark:text-lime-500 mr-2"> Seg
                                </label>
                                <label class="flex items-center dark:text-gray-200 text-gray-800">
                                    <input type="checkbox" name="days_of_week[]" value="2" class="form-checkbox h-5 w-5 text-blue-500 rounded dark:text-lime-500 mr-2"> Ter
                                </label>
                                <label class="flex items-center dark:text-gray-200 text-gray-800">
                                    <input type="checkbox" name="days_of_week[]" value="3" class="form-checkbox h-5 w-5 text-blue-500 rounded dark:text-lime-500 mr-2"> Qua
                                </label>
                                <label class="flex items-center dark:text-gray-200 text-gray-800">
                                    <input type="checkbox" name="days_of_week[]" value="4" class="form-checkbox h-5 w-5 text-blue-500 rounded dark:text-lime-500 mr-2"> Qui
                                </label>
                                <label class="flex items-center dark:text-gray-200 text-gray-800">
                                    <input type="checkbox" name="days_of_week[]" value="5" class="form-checkbox h-5 w-5 text-blue-500 rounded dark:text-lime-500 mr-2"> Sex
                                </label>
                                <label class="flex items-center dark:text-gray-200 text-gray-800">
                                    <input type="checkbox" name="days_of_week[]" value="6" class="form-checkbox h-5 w-5 text-blue-500 rounded dark:text-lime-500 mr-2"> Sáb
                                </label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="repeat_until" class="block dark:text-white text-gray-800">Repetir até</label>
                            <input type="date" name="repeat_until" id="repeat_until" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                            @error('repeat_until')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <span id="repeat_until_error" class="text-red-500 text-sm"></span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-10">
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm">Adicionar</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const repeatCheckbox = document.getElementById('repeat');
        const repeatOptions = document.getElementById('repeat-options');

        repeatCheckbox.addEventListener('change', function () {
            if (this.checked) {
                repeatOptions.style.display = 'block';
            } else {
                repeatOptions.style.display = 'none';
            }
        });

        const trainingForm = document.getElementById('trainingForm');
        const closedDates = @json($closures);

        trainingForm.addEventListener('submit', function (event) {
            const startTimeInput = document.getElementById('start_time');
            const startDateInput = document.getElementById('start_date');
            const durationInput = document.getElementById('duration');
            const startDateError = document.getElementById('start_date_error');
            const startTimeError = document.getElementById('start_time_error');
            const durationError = document.getElementById('duration_error');
            const roomSelect = document.getElementById('room_id');
            const maxStudentsInput = document.getElementById('max_students');

            const selectedRoom = roomSelect.options[roomSelect.selectedIndex];
            const roomCapacity = parseInt(selectedRoom.getAttribute('data-capacity'));

            if (parseInt(maxStudentsInput.value) > roomCapacity) {
                startDateError.innerText = 'O número máximo de alunos não pode exceder a capacidade da sala.';
                event.preventDefault();
                return;
            }

            const horarioInicioSemanal = '{{ $horarioInicioSemanal }}';
            const horarioFimSemanal = '{{ $horarioFimSemanal }}';
            const horarioInicioSabado = '{{ $horarioInicioSabado }}';
            const horarioFimSabado = '{{ $horarioFimSabado }}';

            const startTime = startTimeInput.value;
            const startDate = new Date(startDateInput.value);
            const duration = parseInt(durationInput.value);
            const endTime = new Date(startDate);
            endTime.setMinutes(startDate.getMinutes() + duration);

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
                startTimeError.innerText = 'A hora de início deve estar entre ' + horarioInicioSemanal + ' e ' + horarioFimSemanal + ' nos dias de semana.';
                isValid = false;
            } else if (dayOfWeek == 6 && (startTime < horarioInicioSabado || startTime > horarioFimSabado || endTime > horarioFimSabado)) {
                startTimeError.innerText = 'A hora de início deve estar entre ' + horarioInicioSabado + ' e ' + horarioFimSabado + ' no sábado.';
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
