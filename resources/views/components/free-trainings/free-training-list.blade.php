@php
    use Carbon\Carbon;
    $horarioInicio = Carbon::createFromFormat('H:i', setting('horario_inicio', '06:00'));
    $horarioFim = Carbon::createFromFormat('H:i', setting('horario_fim', '23:59'));
    $currentDateTime = Carbon::now();
    $user = auth()->user();
    $hasActiveMembership = $user->membership && $user->membership->status->name === 'active';
@endphp

<div class="container mx-auto mt-10 mb-10">
    @if (auth()->check() && auth()->user()->hasRole('client'))
        @php
            $membership = $user->membership;
            $today = Carbon::today();
            $availablePacks = $membership->packs()
                ->where('quantity_remaining', '>', 0)
                ->where('expiry_date', '>=', $today)
                ->where('has_personal_trainer', false)
                ->orderBy('expiry_date', 'asc')
                ->get();
            $earliestExpiringPack = $availablePacks->first();
        @endphp

        @if ($availablePacks->isNotEmpty())
            <div
                class="bg-gray-300 dark:bg-gray-700 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:text-gray-200 p-4 mb-6"
                role="alert">
                <p class="font-bold mb-1">Possui Packs de aulas para utilizar:</p>
                <ul class="list-disc list-inside">
                    @foreach ($availablePacks as $pack)
                        <li class="ml-6">
                            {{ $pack->name }}: {{ $pack->pivot->quantity_remaining }} aulas restantes, expira
                            em {{ Carbon::parse($pack->pivot->expiry_date)->format('d/m/Y') }}.
                        </li>
                    @endforeach
                </ul>
                <p class="mt-2">O pack que será utilizado é o que expira mais brevemente.</p>
            </div>
        @else
            <div
                class="bg-gray-300 dark:bg-gray-700 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:text-gray-200 p-4 mb-6"
                role="alert">
                <p class="font-bold">Adquira Packs para Participar nas Aulas</p>
                <p>Para usufruir das nossas aulas e inscrever-se, adquira um dos nossos packs de aulas. Clique no botão
                    abaixo para ver os packs que temos disponíveis para si!</p>
                <a href="{{ route('packs.index') }}"
                   class="mt-4 inline-block text-white bg-lime-500 bg-blue-500 px-3 py-1 rounded-md hover:bg-lime-400 hover:bg-blue-400">Ver
                    Packs</a>
            </div>
        @endif
    @endif

    @can('create', App\Models\FreeTraining::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ route('free-trainings.create') }}">
                <button type="button"
                        class="bg-blue-500 text-white px-2 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-bold flex items-center text-xs sm:text-sm">
                    <i class="fa-solid fa-plus w-4 h-4 mr-1 sm:mr-2"></i>
                    Adicionar Vários Treinos Livres
                </button>
            </a>
            <a href="{{ route('free-trainings.showMultiDelete') }}">
                <button type="button"
                        class="bg-red-600 text-white flex items-center px-2 py-2 rounded-md hover:bg-red-500 dark:bg-red-500 dark:hover:text-gray-800 font-bold text-xs sm:text-sm">
                    <i class="fa-solid fa-trash-can w-4 h-4 mr-1 sm:mr-2"></i>
                    Remover Vários Treinos
                </button>
            </a>
        </div>
    @endcan

    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div class="flex justify-between items-center mb-5">
        @if ($selectedWeek->gt($currentWeek) || auth()->user()->hasRole('admin'))
            <form method="POST" action="{{ route('free-trainings.changeWeek') }}">
                @csrf
                <input type="hidden" name="direction" value="previous">
                <button type="submit"
                        class="bg-gray-300 text-gray-800 px-2 py-2 rounded-md hover:bg-gray-400 flex items-center text-xs sm:text-sm">
                    <i class="fa-solid fa-backward"></i>
                </button>
            </form>
        @endif
        <span
            class="font-bold dark:text-white text-gray-800 text-center truncate flex-grow flex justify-center items-center text-xs sm:text-sm">
            <i class="fa-solid fa-calendar-day mr-2"></i>{{ $selectedWeek->startOfWeek()->format('d/m/Y') }} - {{ $selectedWeek->endOfWeek()->format('d/m/Y') }}
        </span>
        @if ($selectedWeek->lt($currentWeek->copy()->addWeek()) || !auth()->user()->hasRole('client'))
            <form method="POST" action="{{ route('free-trainings.changeWeek') }}">
                @csrf
                <input type="hidden" name="direction" value="next">
                <button type="submit"
                        class="bg-gray-300 text-gray-800 px-2 py-2 rounded-md hover:bg-gray-400 flex items-center text-xs sm:text-sm">
                    <i class="fa-solid fa-forward"></i>
                </button>
            </form>
        @endif
    </div>

    <div class="flex justify-center mb-6 flex-wrap">
        @foreach (['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $index => $day)
            @php
                $date = \Carbon\Carbon::parse($selectedWeek)->startOfWeek()->addDays($index)->format('Y-m-d');
                $isActive = \Carbon\Carbon::parse($selectedDay)->isSameDay(\Carbon\Carbon::parse($date));
            @endphp
            <a href="{{ route('free-trainings.selectDay', $date) }}"
               class="mx-1 px-2 py-1 rounded-md text-xs sm:text-sm {{ $isActive ? 'bg-blue-500 text-white dark:bg-lime-500' : 'bg-gray-300 text-gray-800' }}">
                {{ $day }}<br>{{ \Carbon\Carbon::parse($date)->format('d/m') }}
            </a>
        @endforeach
    </div>

    <div class="border border-gray-200 bg-gray-200 dark:bg-gray-700 dark:border-gray-700 p-4 rounded-lg">
        <h3 class="mb-4 ml-2 text-gray-700 dark:text-gray-200 font-semibold rounded-t-lg w-full">
            Treinos para {{ \Carbon\Carbon::parse($selectedDay)->locale('pt')->isoFormat('dddd, D MMMM YYYY') }}
        </h3>
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
            <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                <th scope="col"
                    class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Hora
                </th>
                <th scope="col"
                    class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Treino
                </th>
            </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
            @for ($hour = $horarioInicio->hour; $hour <= $horarioFim->hour; $hour++)
                <tr>
                    <td class="px-2 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                        {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                        @if(isset($freeTrainings[$selectedDay->format('Y-m-d')]))
                            <div class="flex flex-wrap">
                                @foreach ($freeTrainings[$selectedDay->format('Y-m-d')] as $freeTraining)
                                    @php
                                        $startDateTime = Carbon::parse($freeTraining->start_date);
                                        $endDateTime = Carbon::parse($freeTraining->end_date);
                                        $isFreeTrainingStarted = $currentDateTime->gte($startDateTime);
                                        $userPresence = $freeTraining->users()->where('user_id', auth()->id())->exists();
                                        $hasMarkedAllPresences = $freeTraining->users()->wherePivotNotNull('presence')->count() == $freeTraining->users()->count();
                                        $isAdminOrPT = auth()->user()->hasRole('admin') || auth()->user()->hasRole('personal_trainer');
                                    @endphp
                                    @if ($startDateTime->hour == $hour)
                                        <div
                                            class="inline-block sm:p-2 p-1 mb-2 bg-gray-200 dark:bg-gray-700 rounded shadow transform transition duration-300 ease-in-out min-w-full sm:min-w-[350px] ml-0 sm:ml-4 relative @if($isAdminOrPT) hover:scale-105 cursor-pointer @endif"
                                            @if($isAdminOrPT) onclick="window.location='{{ route('free-trainings.show', $freeTraining->id) }}'" @endif>
                                            @if ($userPresence)
                                                <div class="ribbon"><span>Inscrito</span></div>
                                            @endif
                                            <div class="flex flex-col sm:flex-row justify-between items-center pr-4">
                                                <div class="mb-2 sm:mb-0">
                                                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-100">{{ $freeTraining->name }}</h3>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        <i class="fa-solid fa-clock"></i> {{ $startDateTime->format('H:i') }}
                                                        - {{ $endDateTime->format('H:i') }}
                                                        ({{ $startDateTime->diffInMinutes($endDateTime) }} min)
                                                    </p>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        <i class="fa-solid fa-square-check"></i>
                                                        Inscrições: {{ $freeTraining->users()->count() }}
                                                        /{{ $freeTraining->max_students }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2 sm:ml-4">
                                                    @if($isAdminOrPT && $isFreeTrainingStarted && !$hasMarkedAllPresences)
                                                        <a href="{{ route('free-trainings.show', $freeTraining->id) }}"
                                                           class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-400"
                                                           onclick="event.stopPropagation()">
                                                            <i class="fa-solid fa-check"></i> Marcar Presenças
                                                        </a>
                                                    @endif
                                                    @can('delete', $freeTraining)
                                                        @if(!$isFreeTrainingStarted)
                                                            <button type="button"
                                                                    class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-400"
                                                                    onclick="confirmDelete({{ $freeTraining->id }}); event.stopPropagation();">
                                                                <i class="fa-solid fa-trash"></i> Remover
                                                            </button>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </div>
                                            @if(!$isFreeTrainingStarted)
                                                <div class="mt-2">
                                                    @if ($userPresence)
                                                        <form id="cancel-form-{{ $freeTraining->id }}"
                                                              action="{{ route('free-trainings.cancel', $freeTraining->id) }}"
                                                              method="POST" class="inline text-sm">
                                                            @csrf
                                                            <button type="button"
                                                                    class="bg-red-500 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-400 text-sm"
                                                                    onclick="confirmCancel({{ $freeTraining->id }}, this); event.stopPropagation();">
                                                                <i class="fa-solid fa-x w-4 h-4 mr-2"></i>
                                                                Cancelar Inscrição
                                                            </button>
                                                        </form>
                                                    @elseif($freeTraining->users()->count() < $freeTraining->max_students && $currentDateTime->lt($startDateTime) && $hasActiveMembership)
                                                        <form method="POST"
                                                              action="{{ route('free-trainings.enroll', $freeTraining->id) }}"
                                                              class="inline text-sm">
                                                            @csrf
                                                            <button type="button"
                                                                    class="bg-lime-400 bg-blue-500 text-white flex items-center px-2 py-1 rounded-md hover:bg-green-400 text-sm"
                                                                    onclick="confirmEnroll({{ $freeTraining->id }}, this); event.stopPropagation();">
                                                                <i class="fa-solid fa-check w-4 h-4 mr-2"></i>
                                                                Inscrever-me
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>
</div>

@if($showMembershipModal)
    <div id="membership-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
        <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
            <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Atenção</h2>
            <p class="mb-4 text-gray-700 dark:text-gray-200">Necessita de uma matrícula ativa para se inscrever em
                qualquer treino.</p>
            <div class="flex justify-end">
                <button type="button" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500"
                        onclick="closeMembershipModal()">Fechar
                </button>
            </div>
        </div>
    </div>
@endif

<div id="confirmation-modal"
     class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400"
                    onclick="cancelAction()">Cancelar
            </button>
            <form id="confirmation-form" method="POST" class="inline" onsubmit="disableConfirmButton(this)">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500">Confirmar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        openModal('Pretende eliminar?', 'Não poderá reverter isso!', `/free-trainings/${id}`, 'DELETE');
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function closeMembershipModal() {
        document.getElementById('membership-modal').classList.add('hidden');
    }

    function confirmEnroll(id, button) {
        openModal('Pretende inscrever-se?', '', `/free-trainings/${id}/enroll`, 'POST');
    }

    function confirmCancel(id, button) {
        openModal('Pretende cancelar a inscrição?', '', `/free-trainings/${id}/cancel`, 'POST');
    }

    function disableConfirmButton(form) {
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin w-4 h-4 mr-2"></i> Processando...';
    }

    function openModal(title, message, actionUrl, method) {
        document.getElementById('confirmation-title').innerText = title;
        document.getElementById('confirmation-message').innerText = message;
        const confirmationForm = document.getElementById('confirmation-form');
        confirmationForm.action = actionUrl;
        confirmationForm.querySelector('input[name="_method"]').value = method;
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if($showMembershipModal)
        document.getElementById('membership-modal').classList.remove('hidden');
        @endif
    });
</script>
