@php use Carbon\Carbon; @endphp
<div class="container mx-auto mt-10 mb-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('trainings.index') }}"
                   class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center">
                <h1 class="mb-8 mt-4 dark:text-lime-400 text-gray-800 font-semibold">{{ $training->trainingType->name }}</h1>
            </div>

            <div class="mb-4">
                <label for="room" class="block text-gray-800 dark:text-white">Sala</label>
                <input type="text" name="room" id="room" value="{{ $training->room->name }}" disabled
                       class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="personal_trainer" class="block text-gray-800 dark:text-white">Personal Trainer</label>
                <input type="text" name="personal_trainer" id="personal_trainer"
                       value="{{ $training->personalTrainer->firstLastName() }}" disabled
                       class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-gray-800 dark:text-white">Data de Início</label>
                <input type="text" name="start_date" id="start_date"
                       value="{{ Carbon::parse($training->start_date)->format('d/m/Y H:i') }}" disabled
                       class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-gray-800 dark:text-white">Data de Término</label>
                <input type="text" name="end_date" id="end_date"
                       value="{{ Carbon::parse($training->end_date)->format('d/m/Y H:i') }}" disabled
                       class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="duration" class="block text-gray-800 dark:text-white">Duração</label>
                <input type="text" name="duration" id="duration"
                       value="{{ Carbon::parse($training->start_date)->diffInMinutes(Carbon::parse($training->end_date)) }} minutos"
                       disabled
                       class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            @php
                $userPresence = $training->users()->where('user_id', auth()->id())->exists();
                $userCancelled = $training->users()->where('user_id', auth()->id())->wherePivot('cancelled', true)->exists();
                $currentDateTime = Carbon::now();
                $remainingSpots = $training->trainingType->max_capacity - $training->users()->wherePivot('cancelled', false)->count();
                $trainingStartDateTime = Carbon::parse($training->start_date);
                $trainingEndDateTime = Carbon::parse($training->end_date);
                $userHasActiveMembership = auth()->user()->membership && auth()->user()->membership->status->name === 'active';
                $presenceMarked = $training->users->every(fn($user) => !is_null($user->pivot->presence));

                // Check if the user has available packs for this training type
                $today = Carbon::today();
                $hasAvailablePack = null;
                if($userHasActiveMembership) {
                    $hasAvailablePack = auth()->user()->membership->packs()
                        ->where('quantity_remaining', '>', 0)
                        ->where('expiry_date', '>=', $today)
                        ->where('training_type_id', $training->training_type_id)
                        ->exists();
                }
            @endphp

            @if ($userCancelled)
                <p class="text-red-500 mb-5">
                    <i class="fa-solid fa-ban mr-1"></i>
                    Cancelou a inscrição. Não pode voltar a inscrever-se e o treino não será reembolsado.
                </p>
            @endif

            <div class="mb-4">
                <h2 class="block text-gray-800 dark:text-white mb-2">Inscrições: {{ $training->users()->wherePivot('cancelled', false)->count() }}/{{ $training->trainingType->max_capacity }}</h2>
            </div>

            @if (auth()->user()->hasRole('admin') || auth()->user()->id === $training->personal_trainer_id)
                <div class="mb-4">
                    <h2 class="block text-gray-800 dark:text-white mb-2">Alunos Inscritos</h2>
                    @if ($training->users->isEmpty())
                        <p class="text-gray-800 dark:text-white">Ainda não existem alunos inscritos neste treino.</p>
                    @else
                        @if ($currentDateTime->gte($trainingStartDateTime))
                            @if (!$presenceMarked)
                                <form action="{{ route('trainings.markPresence', $training->id) }}" method="POST">
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
                                        @foreach ($training->users as $user)
                                            @if ($user->pivot->cancelled === false && is_null($user->pivot->presence))
                                                <tr>
                                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
                                                        <a href="{{ url('users/' . $user->id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                                            {{ $user->firstLastName() }}
                                                        </a>
                                                    </td>
                                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                                        <div class="flex items-center">
                                                            <input type="radio" name="presence[{{ $user->id }}]" value="1"
                                                                   @if($user->pivot->presence) checked @endif
                                                                   class="form-radio mr-2 ml-4 text-blue-500 dark:text-lime-400">
                                                            <i class="fa-solid fa-check text-green-500"></i>
                                                            <input type="radio" name="presence[{{ $user->id }}]" value="0"
                                                                   @if(!$user->pivot->presence) checked @endif
                                                                   class="form-radio mr-2 ml-4 text-blue-500 dark:text-lime-400">
                                                            <i class="fa-solid fa-x text-red-500"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
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
                                    @foreach ($training->users as $user)
                                        @if ($user->pivot->cancelled === false)
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
                                        @else
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
                                                    <a href="{{ url('users/' . $user->id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                                        {{ $user->firstLastName() }}
                                                    </a>
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                                    <div class="flex items-center">
                                                        <i class="fa-solid fa-ban text-red-500"></i> Cancelado
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @else
                            <ul class="list-disc list-inside dark:text-white">
                                @foreach ($training->users as $user)
                                    <li>
                                        <a href="{{ url('memberships/' . $user->membership->id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                            {{ $user->firstLastName() }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </div>
            @endif

            @if (auth()->user()->hasRole('client'))
                <div class="flex justify-end gap-2 mt-10">
                    @if ($currentDateTime->lt($trainingStartDateTime))
                        @if ($userHasActiveMembership)
                            @if (!$userPresence && !$userCancelled && $remainingSpots > 0)
                                @if($hasAvailablePack)
                                    <form id="enroll-form-{{ $training->id }}" action="{{ route('trainings.enroll', $training->id) }}" method="POST" class="inline text-sm">
                                        @csrf
                                        <button type="submit"
                                                class="dark:bg-lime-400 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-green-400 text-sm">
                                            <i class="fa-solid fa-check w-4 h-4 mr-2"></i>
                                            Inscrever-me
                                        </button>
                                    </form>
                                @else
                                    <button type="button" disabled
                                            class="dark:bg-gray-600 bg-gray-400 text-white py-2 px-4 rounded-md text-sm">
                                        <i class="fa-solid fa-check w-4 h-4 mr-2"></i>
                                        Inscrever-me
                                    </button>
                                @endif
                            @elseif ($userPresence && !$userCancelled)
                                <form id="cancel-form-{{ $training->id }}" action="{{ route('trainings.cancel', $training->id) }}" method="POST" class="inline text-sm">
                                    @csrf
                                    <button type="submit"
                                            class="bg-red-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-red-400 text-sm">
                                        <i class="fa-solid fa-x w-4 h-4 mr-2"></i>
                                        Cancelar Inscrição
                                    </button>
                                </form>
                            @endif
                        @else
                            <p class="text-gray-700 dark:text-gray-200 mb-5">
                                <i class="fa-solid fa-ban mr-1"></i>
                                Necessita de uma matrícula ativa para se inscrever em qualquer treino.
                            </p>
                        @endif
                    @else
                        <p class="text-gray-700 dark:text-gray-200 mb-5">
                            <i class="fa-solid fa-info-circle mr-1"></i>
                            Este treino está a decorrer ou já finalizou.
                        </p>
                    @endif
                </div>
            @endif

            @if(auth()->user()->hasRole('admin') || auth()->user()->id === $training->personal_trainer_id)
                @if($currentDateTime->lt($trainingStartDateTime))
                    <div class="flex justify-end items-center mb-4 mt-10">
                        <a href="{{ url('trainings/' . $training->id . '/edit') }}"
                           class="bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400 mr-2">
                            <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                            Editar
                        </a>
                        <form id="delete-form-{{$training->id}}" action="{{ url('trainings/' . $training->id) }}"
                              method="POST" class="inline mr-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500"
                                    id="delete-button">
                                <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                Eliminar
                            </button>
                        </form>
                    </div>
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
    function openModal(title, message, actionUrl, method = 'POST') {
        document.getElementById('confirmation-title').innerText = title;
        document.getElementById('confirmation-message').innerText = message;
        const form = document.getElementById('confirmation-form');
        form.action = actionUrl;
        form.setAttribute('method', 'POST');

        // Remove existing _method input if present
        const existingMethodInput = form.querySelector('input[name="_method"]');
        if (existingMethodInput) {
            existingMethodInput.remove();
        }

        // Add _method input if method is DELETE or PUT
        if (method === 'DELETE' || method === 'PUT') {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = method;
            form.appendChild(methodInput);
        }

        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function confirmEnroll(id) {
        openModal('Pretende inscrever-se?', '', `/trainings/${id}/enroll`);
    }

    function confirmCancel(id) {
        openModal('Pretende cancelar a inscrição?', 'Se cancelar agora não poderá voltar a inscrever-se neste treino e não irá ser reembolsado.', `/trainings/${id}/cancel`);
    }

    function confirmDelete(id) {
        openModal('Pretende eliminar?', 'Não poderá reverter isso!', `/trainings/${id}`, 'DELETE');
    }
</script>
