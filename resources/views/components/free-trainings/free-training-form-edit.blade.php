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
                <a href="{{ route('free_trainings.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="mt-10 text-center">
                <h1 class="mb-6 dark:text-lime-400 font-semibold text-gray-800">Editar Treino Livre</h1>
            </div>
            <form method="POST" action="{{ route('free_trainings.update', $freeTraining) }}" id="update-form">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="max_students" class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                    <input type="number" name="max_students" id="max_students" value="{{ old('max_students', $freeTraining->max_students) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                    @error('max_students')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <span id="max-students-error-msg" class="text-red-500 text-sm"></span>
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block dark:text-white text-gray-800">Data de Início</label>
                    <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($freeTraining->start_date)->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                    @error('start_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <span id="start_date_error" class="text-red-500 text-sm"></span>
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block dark:text-white text-gray-800">Data de Fim</label>
                    <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($freeTraining->end_date)->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                    @error('end_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <span id="end_date_error" class="text-red-500 text-sm"></span>
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
        </div>
    </div>
</div>

<script>
    function confirmarAtualizacao() {
        const maxStudentsInput = document.getElementById('max_students');
        const maxStudentsErrorMsg = document.getElementById('max-students-error-msg');
        const currentEnrolled = {{ $freeTraining->users->count() }};

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
</script>
