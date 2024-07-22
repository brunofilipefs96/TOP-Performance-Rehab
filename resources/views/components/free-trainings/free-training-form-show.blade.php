@php
    use Carbon\Carbon;
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
                <h1 class="mb-6 dark:text-lime-400 font-semibold text-gray-800">{{ $freeTraining->name }}</h1>
            </div>
            <div class="mb-4">
                <label class="block dark:text-white text-gray-800">Tipo de Treino</label>
                <p class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:bg-gray-600 dark:text-white">{{ $freeTraining->trainingType->name }}</p>
            </div>
            <div class="mb-4">
                <label class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                <p class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:bg-gray-600 dark:text-white">{{ $freeTraining->max_students }}</p>
            </div>
            <div class="mb-4">
                <label class="block dark:text-white text-gray-800">Data e Hora de Início</label>
                <p class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:bg-gray-600 dark:text-white">{{ Carbon::parse($freeTraining->start_date)->format('d/m/Y H:i') }}</p>
            </div>
            <div class="mb-4">
                <label class="block dark:text-white text-gray-800">Data e Hora de Término</label>
                <p class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:bg-gray-600 dark:text-white">{{ Carbon::parse($freeTraining->end_date)->format('d/m/Y H:i') }}</p>
            </div>

            @php
                $currentDateTime = Carbon::now();
                $trainingStartDateTime = Carbon::parse($freeTraining->start_date);
                $presenceMarked = $freeTraining->users->every(fn($user) => !is_null($user->pivot->presence));
            @endphp

            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('personal_trainer'))
                <div class="mb-4">
                    <h2 class="block text-gray-800 dark:text-white mb-2">Inscrições</h2>
                    @if ($freeTraining->users->isEmpty())
                        <p class="text-gray-800 dark:text-white">Ainda não existem alunos inscritos neste treino livre.</p>
                    @else
                        @if ($currentDateTime->gte($trainingStartDateTime))
                            @if (!$presenceMarked)
                                <form action="{{ route('free-trainings.markPresence', $freeTraining->id) }}" method="POST">
                                    @csrf
                                    <table class="min-w-full bg-white dark:bg-gray-800">
                                        <thead>
                                        <tr>
                                            <th class="py-2 px-4 bg-gray-200 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                                                Nome
                                            </th>
                                            <th class="py-2 px-4 bg-gray-200 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                                                Presença
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($freeTraining->users as $user)
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
                                                    <a href="{{ url('users/' . $user->id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                                        {{ $user->firstLastName() }}
                                                    </a>
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                                    <div class="flex items-center">
                                                        <input type="radio" name="presence[{{ $user->id }}]" value="1"
                                                               @if(!is_null($user->pivot->presence) && $user->pivot->presence) checked @endif
                                                               class="form-radio mr-2 ml-4 text-blue-500 dark:text-lime-400">
                                                        <i class="fa-solid fa-check text-green-500"></i>
                                                        <input type="radio" name="presence[{{ $user->id }}]" value="0"
                                                               @if(!is_null($user->pivot->presence) && !$user->pivot->presence) checked @endif
                                                               class="form-radio mr-2 ml-4 text-blue-500 dark:text-lime-400">
                                                        <i class="fa-solid fa-x text-red-500"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="flex justify-end mt-4">
                                        <button type="submit"
                                                class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm">
                                            Enviar Presenças
                                        </button>
                                    </div>
                                </form>
                            @else
                                <table class="min-w-full bg-white dark:bg-gray-800">
                                    <thead>
                                    <tr>
                                        <th class="py-2 px-4 bg-gray-200 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                                            Nome
                                        </th>
                                        <th class="py-2 px-4 bg-gray-200 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                                            Presença
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($freeTraining->users as $user)
                                        <tr>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
                                                <a href="{{ url('users/' . $user->id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                                    {{ $user->firstLastName() }}
                                                </a>
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                                <div class="flex items-center">
                                                    @if($user->pivot->presence)
                                                        <i class="fa-solid fa-check text-green-500"></i>
                                                    @else
                                                        <i class="fa-solid fa-x text-red-500"></i>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @else
                            <ul class="list-disc list-inside dark:text-white">
                                @foreach ($freeTraining->users as $user)
                                    <li>
                                        <a href="{{ url('users/' . $user->id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                            {{ $user->firstLastName() }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </div>

                @if(auth()->user()->hasRole('admin'))
                    @if($currentDateTime->lt($trainingStartDateTime))
                        <div class="flex justify-end items-center mb-4 mt-10">
                            <form id="delete-form-{{$freeTraining->id}}" action="{{ route('free-trainings.destroy', $freeTraining->id) }}"
                                  method="POST" class="inline mr-2">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500"
                                        id="delete-button" onclick="confirmDelete({{ $freeTraining->id }})">
                                    <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </div>
</div>

<div id="confirmation-modal"
     class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400"
                    onclick="cancelAction()">Cancelar
            </button>
            <form id="confirmation-form" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500">Confirmar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(title, message, actionUrl) {
        document.getElementById('confirmation-title').innerText = title;
        document.getElementById('confirmation-message').innerText = message;
        document.getElementById('confirmation-form').action = actionUrl;
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function confirmDelete(id) {
        openModal('Pretende eliminar?', 'Não poderá reverter isso!', `/free-trainings/${id}`);
    }
</script>
