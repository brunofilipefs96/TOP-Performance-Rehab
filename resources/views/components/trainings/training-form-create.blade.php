<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <div>
                <h1 class="mb-2 dark:text-lime-400 font-semibold text-gray-800">Criar Treino</h1>
            </div>
            @if ($trainingTypes->isEmpty() || $rooms->isEmpty() || $personalTrainers->isEmpty())
                <div class="mb-4 dark:text-white text-gray-800">
                    <p class="mb-2">Para criar um treino, você precisa adicionar pelo menos um tipo de treino, uma sala e um personal trainer.</p>
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
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="training_type_id" class="block dark:text-white text-gray-800">Tipo de Treino</label>
                        <select name="training_type_id" id="training_type_id" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
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
                        <select name="room_id" id="room_id" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach
                        </select>
                        @error('room_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="max_students" class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                        <input type="number" name="max_students" id="max_students" value="{{ old('max_students') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        @error('max_students')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="personal_trainer_id" class="block dark:text-white text-gray-800">Personal Trainer</label>
                        @if (Auth::user()->hasRole('admin'))
                            <select name="personal_trainer_id" id="personal_trainer_id" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                                @foreach ($personalTrainers as $trainer)
                                    <option value="{{ $trainer->id }}" {{ old('personal_trainer_id') == $trainer->id ? 'selected' : '' }}>{{ $trainer->firstLastName() }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="personal_trainer_id" id="personal_trainer_id" value="{{ auth()->user()->id }}">
                            <input type="text" value="{{ auth()->user()->firstLastName() }}" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" readonly>
                        @endif
                        @error('personal_trainer_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="start_date" class="block dark:text-white text-gray-800">Data</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        @error('start_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="start_time" class="block dark:text-white text-gray-800">Hora de Início</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="duration" class="block dark:text-white text-gray-800">Duração</label>
                        <select name="duration" id="duration" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                            <option value="30">30 minutos</option>
                            <option value="45">45 minutos</option>
                            <option value="60">60 minutos</option>
                            <option value="75">75 minutos</option>
                            <option value="90">90 minutos</option>
                        </select>
                        @error('duration')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Adicionando campos de repetição -->
                    <div class="mb-4">
                        <label for="repeat" class="block dark:text-white text-gray-800">Repetir Treino</label>
                        <input type="checkbox" name="repeat" id="repeat" class="mt-1">
                    </div>
                    <div id="repeat-options" style="display: none;">
                        <div class="mb-4">
                            <label class="block dark:text-white text-gray-800">Dias da Semana</label>
                            <div class="flex flex-wrap gap-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="days_of_week[]" value="0" class="mr-2"> Dom
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="days_of_week[]" value="1" class="mr-2"> Seg
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="days_of_week[]" value="2" class="mr-2"> Ter
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="days_of_week[]" value="3" class="mr-2"> Qua
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="days_of_week[]" value="4" class="mr-2"> Qui
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="days_of_week[]" value="5" class="mr-2"> Sex
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="days_of_week[]" value="6" class="mr-2"> Sáb
                                </label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="repeat_until" class="block dark:text-white text-gray-800">Repetir até</label>
                            <input type="date" name="repeat_until" id="repeat_until" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                            @error('repeat_until')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Criar Treino</button>
                        <a href="{{ route('trainings.index') }}" class="inline-block bg-gray-500 mt-4 mb-5 py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 text-white">
                            Cancelar
                        </a>
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
    });
</script>
