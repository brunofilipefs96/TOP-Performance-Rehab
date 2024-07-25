@php
    use Carbon\Carbon;
    $horarioInicioSemana = setting('horario_inicio_semana', '06:00');
    $horarioFimSemana = setting('horario_fim_semana', '23:59');
    $horarioInicioSabado = setting('horario_inicio_sabado', '08:00');
    $horarioFimSabado = setting('horario_fim_sabado', '20:00');
    $hasActiveMembership = false;
@endphp

<div class="container mx-auto mt-5 mb-10">

    @if (auth()->check() && auth()->user()->hasRole('client'))
        @php
            $user = auth()->user();
            $membership = $user->membership;
            $hasActiveMembership = $membership && $membership->status->name === 'active';
        @endphp

        @if ($hasActiveMembership)
            @php
                $today = Carbon::today();
                $availablePacks = $membership->packs()
                    ->where('quantity_remaining', '>', 0)
                    ->where('expiry_date', '>=', $today)
                    ->whereHas('trainingType', function ($query) {
                        $query->where('has_personal_trainer', true);
                    })
                    ->orderBy('expiry_date', 'asc')
                    ->get();
                $earliestExpiringPack = $availablePacks->first();
            @endphp

            @if ($availablePacks->isNotEmpty())
                <div class="bg-gray-300 dark:bg-gray-700 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
                    <p class="font-bold mb-1">Possui Packs de aulas para utilizar:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($availablePacks as $pack)
                            <li class="ml-6">
                                {{ $pack->name }}: {{ $pack->pivot->quantity_remaining }} aulas restantes, expira em {{ Carbon::parse($pack->pivot->expiry_date)->format('d/m/Y') }}.
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-2">O pack que será utilizado é o destinado ao tipo de aula selecionada, utilizando o que expira mais brevemente.</p>
                </div>
            @else
                <div class="bg-gray-300 dark:bg-gray-700 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
                    <p class="font-bold">Adquira Packs para Participar nas Aulas</p>
                    <p>Para usufruir das nossas aulas e inscrever-se, adquira um dos nossos packs de aulas. Clique no botão abaixo para ver os packs que temos disponíveis para si!</p>
                    <a href="{{ route('packs.index') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Ver Packs</a>
                </div>
            @endif
        @endif
    @endif

    @can('create', App\Models\Training::class)
        @if ($type === 'accompanied')
            <div class="mb-10 flex justify-between items-center">
                <a href="{{ route('trainings.create') }}">
                    <button type="button"
                            class="bg-blue-500 text-white px-2 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-bold flex items-center text-xs sm:text-sm">
                        <i class="fa-solid fa-plus w-4 h-4 mr-1 sm:mr-2"></i>
                        Adicionar Treino
                    </button>
                </a>
                <a href="{{ route('trainings.showMultiDelete') }}">
                    <button type="button"
                            class="bg-red-600 text-white flex items-center px-2 py-2 rounded-md hover:bg-red-500 dark:bg-red-500 dark:hover:text-gray-800 font-bold text-xs sm:text-sm">
                        <i class="fa-solid fa-trash-can w-4 h-4 mr-1 sm:mr-2"></i>
                        Remover Vários Treinos
                    </button>
                </a>
            </div>
        @endif
    @endcan

    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div class="flex justify-between items-center mb-5">
        @if ($selectedWeek->gt($currentWeek) || auth()->user()->hasRole('admin') || auth()->user()->hasRole('personal_trainer'))
            <a href="#" onclick="navigateToWeek('{{ $selectedWeek->copy()->subWeek()->format('Y-m-d') }}')"
               class="bg-gray-300 text-gray-800 px-2 py-2 rounded-md hover:bg-gray-400 flex items-center text-xs sm:text-sm">
                <i class="fa-solid fa-backward"></i>
            </a>
        @endif
        <span
            class="text-lg font-bold dark:text-white text-gray-800 text-center truncate flex-grow flex justify-center items-center text-xs sm:text-sm">
            <i class="fa-solid fa-calendar-day mr-2"></i>{{ $selectedWeek->startOfWeek()->format('d/m/Y') }} - {{ $selectedWeek->endOfWeek()->format('d/m/Y') }}
        </span>
        <a href="#" onclick="navigateToWeek('{{ $selectedWeek->copy()->addWeek()->format('Y-m-d') }}')"
           class="bg-gray-300 text-gray-800 px-2 py-2 rounded-md hover:bg-gray-400 flex items-center text-xs sm:text-sm">
            <i class="fa-solid fa-forward"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($daysOfWeek as $day)
            @php
                $formattedDay = Carbon::parse($day)->locale('pt')->isoFormat('dddd');
                $formattedDate = Carbon::parse($day)->format('d/m/Y');
                $dayOfWeek = ucwords($formattedDay) . ' - ' . $formattedDate;
                $dayOfWeekNumber = Carbon::parse($day)->dayOfWeek;
                $horarioInicio = $dayOfWeekNumber === Carbon::SATURDAY ? $horarioInicioSabado : $horarioInicioSemana;
                $horarioFim = $dayOfWeekNumber === Carbon::SATURDAY ? $horarioFimSabado : $horarioFimSemana;
                $isClosed = in_array($day, $closures);
            @endphp
            <div class="border border-gray-200 bg-gray-200 dark:bg-gray-700 dark:border-gray-700 rounded-lg">
                <div class="bg-gray-300 dark:bg-gray-800 p-4 text-gray-700 dark:text-gray-200 font-semibold">
                    {{ $dayOfWeek }}
                </div>
                <div class="p-4 space-y-4">
                    @if ($isClosed)
                        <p class="text-gray-500 dark:text-gray-400">O ginásio encontra-se encerrado neste dia.</p>
                    @else
                        @if (isset($trainings[$day]))
                            @foreach ($trainings[$day] as $training)
                                @php
                                    $userPresence = $training->users()->where('user_id', auth()->id())->exists();
                                    $userCancelled = $training->users()->where('user_id', auth()->id())->wherePivot('cancelled', true)->exists();
                                    $currentDateTime = Carbon::now();
                                    $trainingStartDateTime = Carbon::parse($training->start_date);
                                    $isTrainingStarted = $currentDateTime->gte($trainingStartDateTime);
                                    $maxCapacity = $training->capacity ?? $training->trainingType->max_capacity;
                                    $totalSubscribes = $training->users()->wherePivot('cancelled', false)->count();
                                    $remainingSpots = $maxCapacity - $totalSubscribes;
                                    $hasMarkedAllPresences = $training->users()->wherePivotNotNull('presence')->wherePivot('cancelled', false)->count() == $totalSubscribes;
                                    $hoursDifference = $currentDateTime->diffInHours($trainingStartDateTime, false);

                                    $hasAvailablePack = false;
                                    if (auth()->check() && auth()->user()->hasRole('client') && $hasActiveMembership) {
                                        $today = Carbon::today();
                                        $hasAvailablePack = $membership->packs()
                                            ->where('quantity_remaining', '>', 0)
                                            ->where('expiry_date', '>=', $today)
                                            ->where('training_type_id', $training->training_type_id)
                                            ->exists();
                                    }

                                    $tooltipMessage = $hasAvailablePack ? '' : 'Você não possui pacotes disponíveis para este tipo de treino.';
                                @endphp
                                <div
                                    class="training-card relative dark:bg-gray-800 bg-gray-300 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105"
                                    data-id="{{ $training->id }}" data-date="{{ $training->start_date }}"
                                    data-start-time="{{ $training->start_time }}">
                                    <a href="{{ route('trainings.show', $training->id) }}"
                                       class="block p-4 dark:bg-gray-800 bg-gray-300">
                                        @if ($userPresence && !$userCancelled)
                                            <div class="ribbon"><span>Inscrito</span></div>
                                        @endif
                                        <h3 class="text-lg font-semibold mb-2 text-gray-700 dark:text-gray-100">{{ $training->trainingType->name }}</h3>
                                        <div class="dark:text-gray-400 text-gray-600 mb-2 flex items-center text-sm">
                                            <i class="fa-solid fa-user w-4 h-4 mr-2"></i>
                                            <span>{{ $training->personalTrainer->firstLastName() }}</span>
                                        </div>
                                        <div class="dark:text-gray-400 text-gray-600 mb-2 flex items-center text-sm">
                                            <i class="fa-solid fa-location-dot w-4 h-4 mr-2"></i>
                                            <span>{{ $training->room->name }}</span>
                                        </div>
                                        <div class="dark:text-gray-400 text-gray-600 mb-2 flex items-center text-sm">
                                            <i class="fa-solid fa-clock w-4 h-4 mr-2"></i>
                                            <span>{{ Carbon::parse($training->start_date)->format('H:i') }}</span>
                                        </div>
                                        <div class="dark:text-gray-400 text-gray-600 mb-2 flex items-center text-sm">
                                            <i class="fa-solid fa-hourglass-half w-4 h-4 mr-2"></i>
                                            <span>{{ Carbon::parse($training->start_date)->diffInMinutes(Carbon::parse($training->end_date)) }} min.</span>
                                        </div>
                                        <div class="dark:text-gray-400 text-gray-600 mb-5 flex items-center text-sm">
                                            <i class="fa-solid fa-square-check w-4 h-4 mr-2"></i>
                                            Inscrições: {{ $totalSubscribes }}/{{ $maxCapacity }}
                                            @if ($remainingSpots > 0)
                                                <span class="inline-block w-3 h-3 bg-green-500 rounded-full ml-2"
                                                      title="Vagas disponíveis"></span>
                                            @else
                                                <span class="inline-block w-3 h-3 bg-red-500 rounded-full ml-2"
                                                      title="Cheio"></span>
                                            @endif
                                        </div>
                                        @if ($isTrainingStarted)
                                            <div class="dark:text-gray-400 text-gray-600 mb-2 flex items-center text-sm">
                                                <i class="fa-solid fa-info-circle w-4 h-4 mr-2"></i>
                                                Treino a Decorrer/Finalizado
                                            </div>
                                        @endif
                                        @if ($userCancelled)
                                            <p class="text-red-500 mb-5 text-sm">
                                                <i class="fa-solid fa-ban mr-1"></i>
                                                Cancelou a inscrição. Não pode voltar
                                                a inscrever-se e o treino não será reembolsado.
                                            </p>
                                        @endif
                                    </a>
                                    <div class="flex flex-wrap justify-end items-center gap-2 p-4">
                                        @can('update', $training)
                                            @if(!$isTrainingStarted)
                                                <a href="{{ route('trainings.edit', $training->id) }}"
                                                   class="bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400 text-sm">
                                                    <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                                                    Editar
                                                </a>
                                            @endif
                                        @endcan
                                        @can('delete', $training)
                                            @if(!$isTrainingStarted)
                                                <form id="delete-form-{{ $training->id }}"
                                                      action="{{ route('trainings.destroy', $training->id) }}" method="POST"
                                                      class="inline text-sm" onsubmit="disableConfirmButton(this)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500"
                                                            onclick="confirmDelete({{ $training->id }})">
                                                        <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                        @if (auth()->check() && auth()->user()->hasRole('client') && auth()->user()->cannot('update', $training) && auth()->user()->cannot('delete', $training) && $training->personal_trainer_id !== auth()->user()->id)
                                            @if ($userPresence && !$userCancelled && !$isTrainingStarted)
                                                <form id="cancel-form-{{ $training->id }}" action="{{ route('trainings.cancel', $training->id) }}" method="POST" class="inline text-sm" onsubmit="disableConfirmButton(this)">
                                                    @csrf
                                                    <button type="button" onclick="confirmCancel({{ $training->id }}, {{ $hoursDifference }})"
                                                            class="bg-red-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-red-400 text-sm">
                                                        <i class="fa-solid fa-x w-4 h-4 mr-2"></i>
                                                        Cancelar Inscrição
                                                    </button>
                                                </form>
                                            @elseif(!$userCancelled && !$isTrainingStarted)
                                                @if ($remainingSpots > 0 && $currentDateTime->lt($trainingStartDateTime))
                                                    <form id="enroll-form-{{ $training->id }}" action="{{ route('trainings.enroll', $training->id) }}" method="POST" class="inline text-sm" onsubmit="disableConfirmButton(this)">
                                                        @csrf
                                                        @if($hasAvailablePack)
                                                            <button type="button"
                                                                    class="dark:bg-lime-500 bg-blue-500 hover:bg-green-400 text-white flex items-center px-2 py-1 rounded-md text-sm"
                                                                    onclick="confirmEnroll({{ $training->id }}, this)">
                                                                <i class="fa-solid fa-check w-4 h-4 mr-2"></i>
                                                                Inscrever-me
                                                            </button>
                                                        @else
                                                            <button type="button" disabled title="{{ $tooltipMessage }}"
                                                                    class="dark:bg-gray-600 bg-gray-400 text-white flex items-center px-2 py-1 rounded-md text-sm cursor-not-allowed">
                                                                <i class="fa-solid fa-check w-4 h-4 mr-2"></i>
                                                                Inscrever-me
                                                            </button>
                                                        @endif
                                                    </form>
                                                @endif
                                            @endif
                                        @endif
                                        @if (auth()->check() && (auth()->user()->id === $training->personal_trainer_id || auth()->user()->hasRole('admin')) && $isTrainingStarted && !$hasMarkedAllPresences)
                                            <a href="{{ route('trainings.show', $training->id) }}"
                                               class="absolute bottom-2 right-2 bg-yellow-500 text-white flex items-center px-2 py-1 rounded-md hover:bg-yellow-400 text-sm">
                                                <i class="fa-solid fa-check w-4 h-4 mr-2"></i>
                                                Marcar Presenças
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Nenhum treino disponível.</p>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@if($showMembershipModal)
    <div id="membership-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
        <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
            <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Atenção</h2>
            <p class="mb-4 text-gray-700 dark:text-gray-200">Necessita de uma matrícula ativa para se inscrever em qualquer treino.</p>
            <div class="flex justify-end">
                <button type="button" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500" onclick="closeMembershipModal()">Fechar</button>
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
                @method('DELETE')
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 dark:bg-lime-600 dark:hover:bg-lime-500 text-white px-4 py-2 rounded-md ">Confirmar
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

        const existingMethodInput = form.querySelector('input[name="_method"]');
        if (existingMethodInput) {
            existingMethodInput.remove();
        }

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

    function confirmCancel(id, hoursDifference) {
        let message = 'Pretende cancelar a inscrição?';
        if (hoursDifference < 12) {
            message = 'Se cancelar agora não poderá voltar a inscrever-se neste treino e não irá ser reembolsado.';
        }
        openModal('Pretende cancelar a inscrição?', message, `/trainings/${id}/cancel`);
    }

    function confirmDelete(id) {
        openModal('Pretende eliminar?', 'Não poderá reverter isso!', `/trainings/${id}`, 'DELETE');
    }

    function closeMembershipModal() {
        document.getElementById('membership-modal').classList.add('hidden');
    }

    function navigateToWeek(date) {
        const url = new URL(window.location.href);
        url.searchParams.set('week', date);
        window.location.href = url.toString();
    }
</script>
