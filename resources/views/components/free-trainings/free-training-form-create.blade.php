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
                <a href="{{ route('free-trainings.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="mt-10 text-center">
                <h1 class="mb-6 dark:text-lime-400 font-semibold text-gray-800">Criar Treinos Livres</h1>
                <p class="mb-2 text-gray-600 dark:text-gray-300 text-left">
                    Os treinos são criados, em blocos de 30 minutos, entre as horas definidas para o dia selecionado.
                </p>
                <p class="mb-4 text-gray-600 dark:text-gray-300 text-left">
                    Caso ative a opção de Repetir Treino, os treinos serão criados para os dias selecionados, até a data final definida.
                </p>
            </div>
            @if ($errors->any())
                <div class="mb-4 text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('free-trainings.store') }}" id="freeTrainingForm">
                @csrf
                <div class="mb-4">
                    <label for="max_students" class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                    <input type="number" name="max_students" id="max_students" value="{{ old('max_students') }}" required min="1" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block dark:text-white text-gray-800">Data</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="start_time" class="block dark:text-white text-gray-800">Hora de Início</label>
                    <select name="start_time" id="start_time" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                        <!-- Options populated by JavaScript -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="end_time" class="block dark:text-white text-gray-800">Hora de Fim</label>
                    <select name="end_time" id="end_time" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block dark:text-white text-gray-800">Horários do Ginásio</label>
                    <p class="text-gray-600 dark:text-gray-300">Dias da Semana: {{ $horarioInicioSemanal }} - {{ $horarioFimSemanal }}</p>
                    <p class="text-gray-600 dark:text-gray-300">Sábado: {{ $horarioInicioSabado }} - {{ $horarioFimSabado }}</p>
                    <p class="text-gray-600 dark:text-gray-300">Domingo: Fechado</p>
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="repeat" id="repeat" class="form-checkbox h-5 w-5 text-blue-500 rounded dark:text-lime-500" {{ old('repeat') ? 'checked' : '' }}>
                    <label for="repeat" class="ml-2 block dark:text-white text-gray-800">Repetir Treino</label>
                </div>
                <div id="repeat-options" style="display: none;">
                    <div class="mb-4">
                        <label class="block dark:text-white text-gray-800"><i class="fa-solid fa-calendar-day mr-2"></i>Dias da Semana</label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach (['1' => 'Seg', '2' => 'Ter', '3' => 'Qua', '4' => 'Qui', '5' => 'Sex', '6' => 'Sáb'] as $value => $label)
                                <label class="flex items-center dark:text-gray-200 text-gray-800">
                                    <input type="checkbox" name="days_of_week[]" value="{{ $value }}" class="form-checkbox h-5 w-5 text-blue-500 rounded dark:text-lime-500 mr-2" {{ in_array($value, old('days_of_week', [])) ? 'checked' : '' }}> {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="repeat_until" class="block dark:text-white text-gray-800">Repetir até</label>
                        <input type="date" name="repeat_until" id="repeat_until" value="{{ old('repeat_until') }}" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-10">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm">Adicionar Treinos</button>
                </div>
            </form>
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

        if (repeatCheckbox.checked) {
            repeatOptions.style.display = 'block';
        }

        const startTimeSelect = document.getElementById('start_time');
        const endTimeSelect = document.getElementById('end_time');
        const oldStartTime = '{{ old("start_time") }}';
        const oldEndTime = '{{ old("end_time") }}';

        function populateTimeSelects() {
            for (let hour = 6; hour < 24; hour++) {
                let hourString = hour.toString().padStart(2, '0');
                let option1 = document.createElement('option');
                option1.value = `${hourString}:00`;
                option1.textContent = `${hourString}:00`;

                let option2 = document.createElement('option');
                option2.value = `${hourString}:30`;
                option2.textContent = `${hourString}:30`;

                startTimeSelect.appendChild(option1.cloneNode(true));
                startTimeSelect.appendChild(option2.cloneNode(true));

                endTimeSelect.appendChild(option1.cloneNode(true));
                endTimeSelect.appendChild(option2.cloneNode(true));
            }
        }

        populateTimeSelects();

        if (oldStartTime) {
            startTimeSelect.value = oldStartTime;
        }
        if (oldEndTime) {
            endTimeSelect.value = oldEndTime;
        }
    });
</script>
