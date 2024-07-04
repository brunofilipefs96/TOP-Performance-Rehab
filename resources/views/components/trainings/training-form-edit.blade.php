@php
    use Carbon\Carbon;
    $horarioInicio = setting('horario_inicio', '06:00');
    $horarioFim = setting('horario_fim', '23:59');
@endphp

<div class="container mx-auto mt-10 pt-5 glass">
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
                    <p class="mb-2">Para editar um treino, você precisa adicionar pelo menos um tipo de treino, uma sala e um personal trainer.</p>
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
                        <label for="name" class="block dark:text-white text-gray-800">Nome</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $training->name) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
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
                                <option value="{{ $room->id }}" {{ old('room_id', $training->room_id) == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach
                        </select>
                        @error('room_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="max_students" class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                        <input type="number" name="max_students" id="max_students" value="{{ old('max_students', $training->max_students) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        @error('max_students')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span id="max-students-error-msg" class="text-red-500 text-sm"></span>
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
                    </div>
                    <div class="mb-4">
                        <label for="start_time" class="block dark:text-white text-gray-800">Hora de Início</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($training->start_date)->format('H:i')) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span class="text-sm text-gray-600 dark:text-gray-400">Horário permitido: {{ $horarioInicio }} - {{ $horarioFim }}</span>
                    </div>
                    <div class="mb-4">
                        <label for="duration" class="block dark:text-white text-gray-800">Duração</label>
                        <select name="duration" id="duration" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                            <option value="30" {{ old('duration', $training->duration) == 30 ? 'selected' : '' }}>30 minutos</option>
                            <option value="45" {{ old('duration', $training->duration) == 45 ? 'selected' : '' }}>45 minutos</option>
                            <option value="60" {{ old('duration', $training->duration) == 60 ? 'selected' : '' }}>60 minutos</option>
                            <option value="75" {{ old('duration', $training->duration) == 75 ? 'selected' : '' }}>75 minutos</option>
                            <option value="90" {{ old('duration', $training->duration) == 90 ? 'selected' : '' }}>90 minutos</option>
                        </select>
                        @error('duration')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-2 mt-10">
                        <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm" onclick="confirmarAtualizacao()">Atualizar</button>
                    </div>
                </form>
                <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                    <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende atualizar?</h2>
                        <p class="mb-4 dark:text-lime-200 text-gray-800">Poderá reverter isso!</p>
                        <div class="flex justify-end gap-4">
                            <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                            <button id="confirm-button" class="bg-blue-500 hover:bg-blue-400 dark:bg-lime-500 text-white px-4 py-2 rounded-md dark:hover:bg-lime-400">Atualizar</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function confirmarAtualizacao() {
        const maxStudentsInput = document.getElementById('max_students');
        const maxStudentsErrorMsg = document.getElementById('max-students-error-msg');
        const currentEnrolled = {{ $training->users->count() }};
        if (parseInt(maxStudentsInput.value) < currentEnrolled) {
            if (maxStudentsErrorMsg) {
                maxStudentsErrorMsg.innerText = 'O número máximo de alunos não pode ser menor do que o número de alunos já inscritos.';
            }
            return false;
        }
        if (maxStudentsErrorMsg) {
            maxStudentsErrorMsg.innerText = '';
        }
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById('update-form').submit();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start_date');
        const startTimeInput = document.getElementById('start_time');
        const durationInput = document.getElementById('duration');
        const form = document.getElementById('update-form');
        const errorMsg = document.getElementById('time-error-msg');

        form.addEventListener('submit', function (event) {
            const startDate = new Date(startDateInput.value);
            const startTime = new Date(startDateInput.value + 'T' + startTimeInput.value);
            const now = new Date();
            const duration = parseInt(durationInput.value);
            const endTime = new Date(startTime.getTime() + duration * 60000);

            const horarioInicio = new Date(startDateInput.value + 'T' + '{{ $horarioInicio }}');
            const horarioFim = new Date(startDateInput.value + 'T' + '{{ $horarioFim }}');

            if (startTime < now) {
                event.preventDefault();
                errorMsg.innerText = 'A hora de início deve ser superior à hora atual.';
                return false;
            } else if ((endTime - startTime) / (1000 * 60) < 30) {
                event.preventDefault();
                errorMsg.innerText = 'A duração do treino deve ser de pelo menos 30 minutos.';
                return false;
            } else if ((endTime - startTime) / (1000 * 60) > 90) {
                event.preventDefault();
                errorMsg.innerText = 'A duração do treino não pode exceder 90 minutos.';
                return false;
            } else if (startTime < horarioInicio || startTime > horarioFim || endTime > horarioFim) {
                event.preventDefault();
                errorMsg.innerText = 'O treino deve estar entre ' + '{{ $horarioInicio }}' + ' e ' + '{{ $horarioFim }}' + '.';
                return false;
            } else {
                errorMsg.innerText = '';
            }
        });
    });
</script>
