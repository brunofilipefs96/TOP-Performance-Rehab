<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <div>
                <h1 class="mb-2 dark:text-lime-400 font-semibold text-gray-800">Editar Treino</h1>
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
                <form method="POST" action="{{ route('trainings.update', $training) }}" id="trainingForm" onsubmit="disableConfirmButton(this)">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block dark:text-white text-gray-800">Nome</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $training->name) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="training_type_id" class="block dark:text-white text-gray-800">Tipo de Treino</label>
                        <select name="training_type_id" id="training_type_id" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                            @foreach ($trainingTypes as $type)
                                <option value="{{ $type->id }}" {{ $type->id == $training->training_type_id ? 'selected' : '' }}>{{ $type->name }}</option>
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
                                <option value="{{ $room->id }}" {{ $room->id == $training->room_id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach
                        </select>
                        @error('room_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="max_students" class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                        <input type="number" name="max_students" id="max_students" value="{{ old('max_students', $training->max_students) }}" min="{{ $training->users->count() }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        <p class="text-gray-500 text-sm">Número de alunos já inscritos: {{ $training->users->count() }}</p>
                        <span id="max-students-error-msg" class="text-red-500 text-sm"></span>
                        @error('max_students')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="personal_trainer_id" class="block dark:text-white text-gray-800">Personal Trainer</label>
                        @can('manage-trainers') <!-- Only show this to admin users -->
                        <select name="personal_trainer_id" id="personal_trainer_id" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                            @foreach ($personalTrainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ $training->personal_trainer_id == $trainer->id ? 'selected' : '' }}>{{ $trainer->firstLastName() }}</option>
                            @endforeach
                        </select>
                        @else
                            <input type="hidden" name="personal_trainer_id" id="personal_trainer_id" value="{{ $training->personal_trainer_id }}">
                            <input type="text" value="{{ $training->personalTrainer->firstLastName() }}" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" readonly>
                        @endcan
                        @error('personal_trainer_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="start_date" class="block dark:text-white text-gray-800">Início</label>
                        <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($training->start_date)->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        <p class="text-gray-500 text-sm">A duração mínima é de 20 minutos e a duração máxima é de 2 horas.</p>
                        @error('start_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="end_date" class="block dark:text-white text-gray-800">Término</label>
                        <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($training->end_date)->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        @error('end_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span id="time-error-msg" class="text-red-500 text-sm"></span>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800" onclick="confirmarAtualizacao()">Atualizar Treino</button>
                        <button type="button" onclick="history.back()" class="bg-gray-500 py-2 px-4 rounded-md shadow-sm hover:bg-gray-400 dark:bg-gray-500 dark:hover:bg-gray-400">Cancelar</button>
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
            maxStudentsErrorMsg.innerText = 'O número máximo de alunos não pode ser menor do que o número de alunos já inscritos.';
            return false;
        }
        maxStudentsErrorMsg.innerText = '';
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById('trainingForm').submit();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const startTimeInput = document.getElementById('start_date');
        const endTimeInput = document.getElementById('end_date');
        const form = document.getElementById('trainingForm');
        const errorMsg = document.getElementById('time-error-msg');

        form.addEventListener('submit', function (event) {
            const startTime = new Date(startTimeInput.value);
            const endTime = new Date(endTimeInput.value);
            const now = new Date();

            if (startTime < now) {
                event.preventDefault();
                errorMsg.innerText = 'A hora de início deve ser superior à hora atual.';
                return false;
            } else if (startTime >= endTime) {
                event.preventDefault();
                errorMsg.innerText = 'A hora de término deve ser superior à hora de início.';
                return false;
            } else if ((endTime - startTime) / (1000 * 60) < 20) {
                event.preventDefault();
                errorMsg.innerText = 'A duração do treino deve ser de pelo menos 20 minutos.';
                return false;
            } else if ((endTime - startTime) / (1000 * 60) > 120) {
                event.preventDefault();
                errorMsg.innerText = 'A duração do treino não pode exceder 2 horas.';
                return false;
            } else {
                errorMsg.innerText = '';
            }
        });

        startTimeInput.addEventListener('change', validateTime);
        endTimeInput.addEventListener('change', validateTime);

        function validateTime() {
            const startTime = new Date(startTimeInput.value);
            const endTime = new Date(endTimeInput.value);
            const now = new Date();

            if (startTime < now) {
                startTimeInput.setCustomValidity('A hora de início deve ser superior à hora atual.');
                errorMsg.innerText = 'A hora de início deve ser no futuro.';
            } else if (startTime >= endTime) {
                endTimeInput.setCustomValidity('A hora de término deve ser superior à hora de início.');
                errorMsg.innerText = 'A hora de término deve ser superior à hora de início.';
            } else if ((endTime - startTime) / (1000 * 60) < 20) {
                endTimeInput.setCustomValidity('A duração do treino deve ser de pelo menos 20 minutos.');
                errorMsg.innerText = 'A duração do treino deve ser de pelo menos 20 minutos.';
            } else if ((endTime - startTime) / (1000 * 60) > 120) {
                endTimeInput.setCustomValidity('A duração do treino não pode exceder 2 horas.');
                errorMsg.innerText = 'A duração do treino não pode exceder 2 horas.';
            } else {
                startTimeInput.setCustomValidity('');
                endTimeInput.setCustomValidity('');
                errorMsg.innerText = '';
            }
        }
    });
</script>
