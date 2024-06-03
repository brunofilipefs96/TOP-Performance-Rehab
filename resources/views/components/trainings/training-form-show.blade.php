<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div>
                <h1 class="mb-6 dark:text-lime-400 text-gray-800 font-semibold">{{ $training->name }}</h1>
            </div>

            <div class="mb-4">
                <label for="training_type" class="block text-gray-800 dark:text-white">Tipo de Treino</label>
                <input type="text" name="training_type" id="training_type" value="{{ $training->trainingType->name }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="room" class="block text-gray-800 dark:text-white">Sala</label>
                <input type="text" name="room" id="room" value="{{ $training->room->name }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="personal_trainer" class="block text-gray-800 dark:text-white">Personal Trainer</label>
                <input type="text" name="personal_trainer" id="personal_trainer" value="{{ $training->personalTrainer->firstLastName() }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="max_students" class="block text-gray-800 dark:text-white">Máximo de Alunos</label>
                <input type="number" name="max_students" id="max_students" value="{{ $training->max_students }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-gray-800 dark:text-white">Data de Início</label>
                <input type="text" name="start_date" id="start_date" value="{{ \Carbon\Carbon::parse($training->start_date)->format('d/m/Y H:i') }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-gray-800 dark:text-white">Data de Término</label>
                <input type="text" name="end_date" id="end_date" value="{{ \Carbon\Carbon::parse($training->end_date)->format('d/m/Y H:i') }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="duration" class="block text-gray-800 dark:text-white">Duração</label>
                <input type="text" name="duration" id="duration" value="{{ \Carbon\Carbon::parse($training->start_date)->diffInMinutes(\Carbon\Carbon::parse($training->end_date)) }} minutos" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            @if (auth()->user()->hasRole('admin') || auth()->user()->id === $training->personal_trainer_id)
                <div class="mb-4">
                    <h2 class="block text-gray-800 dark:text-white mb-2">Inscrições</h2>
                    @if ($training->users->isEmpty())
                        <p class="text-gray-800 dark:text-white">Ainda não existem alunos inscritos neste treino.</p>
                    @else
                        @if ($training->start_date < \Carbon\Carbon::now())
                            <table class="min-w-full bg-white dark:bg-gray-800">
                                <thead>
                                <tr>
                                    <th class="py-2 px-4 bg-gray-200 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Nome</th>
                                    <th class="py-2 px-4 bg-gray-200 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Presença</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($training->users as $user)
                                    <tr>
                                        <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $user->firstLastName() }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                            @if ($user->pivot->presence)
                                                <span class="text-green-500">Presente</span>
                                            @else
                                                <span class="text-red-500">Ausente</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <ul class="list-disc list-inside dark:text-white">
                                @foreach ($training->users as $user)
                                    <li>{{ $user->firstLastName() }}</li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </div>
            @endif

            <div class="flex justify-center mt-6">
                <button onclick="history.back()" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Voltar</button>
            </div>
        </div>
    </div>
</div>
