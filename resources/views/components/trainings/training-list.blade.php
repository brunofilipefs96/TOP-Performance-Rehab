@php
    use Carbon\Carbon;
    $horarioInicio = Carbon::createFromFormat('H:i', setting('horario_inicio', '06:00'));
    $horarioFim = Carbon::createFromFormat('H:i', setting('horario_fim', '23:59'));
@endphp

<div class="container mx-auto mt-5">

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
                <button type="button" onclick="openMultiDeleteModal()"
                        class="bg-red-600 text-white flex items-center px-2 py-2 rounded-md hover:bg-red-500 dark:bg-red-500 dark:hover:text-gray-800 font-bold text-xs sm:text-sm">
                    <i class="fa-solid fa-trash-can w-4 h-4 mr-1 sm:mr-2"></i>
                    Remover Vários Treinos
                </button>
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

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($daysOfWeek as $day)
            @php
                $formattedDay = Carbon::parse($day)->locale('pt')->isoFormat('dddd');
                $formattedDate = Carbon::parse($day)->format('d/m/Y');
                $dayOfWeek = ucwords($formattedDay) . ' - ' . $formattedDate;
            @endphp
            <div class="border border-gray-200 bg-gray-200 dark:bg-gray-700 dark:border-gray-700 rounded-lg">
                <div class="bg-gray-300 dark:bg-gray-800 p-4 text-gray-700 dark:text-gray-200 font-semibold">
                    {{ $dayOfWeek }}
                </div>
                <div class="p-4 space-y-4">
                    @if (isset($trainings[$day]))
                        @foreach ($trainings[$day] as $training)
                            @php
                                $userPresence = $training->users()->where('user_id', auth()->id())->exists();
                                $userPresenceFalse = $training->users()->where('user_id', auth()->id())->wherePivot('presence', false)->exists();
                                $currentDateTime = Carbon::now();
                                $trainingStartDateTime = Carbon::parse($training->start_date);
                                $isTrainingStarted = $currentDateTime->gte($trainingStartDateTime);
                                $hasActiveMembership = auth()->user()->membership && auth()->user()->membership->status->name === 'active';
                                $totalSubscribes = $training->users()->count();
                                $remainingSpots = $training->max_students - $totalSubscribes;
                                $hasMarkedAllPresences = $training->users()->wherePivotNotNull('presence')->count() == $totalSubscribes;
                            @endphp
                            <div
                                class="training-card relative dark:bg-gray-800 bg-gray-300 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105"
                                data-id="{{ $training->id }}" data-date="{{ $training->start_date }}"
                                data-start-time="{{ $training->start_time }}">
                                <a href="{{ route('trainings.show', $training->id) }}"
                                   class="block p-4 dark:bg-gray-800 bg-gray-300">
                                    @if ($userPresence && !$userPresenceFalse)
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
                                        Inscrições: {{ $totalSubscribes }}/{{ $training->max_students }}
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
                                    @if ($userPresence && $userPresenceFalse)
                                        <p class="text-red-500 mb-5 text-sm">
                                            <i class="fa-solid fa-ban mr-1"></i>
                                            Cancelou a inscrição com menos de 12 horas de antecedência. Não pode voltar
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
                                                  class="inline text-sm">
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
                                    @if (auth()->check() && auth()->user()->cannot('update', $training) && auth()->user()->cannot('delete', $training) && $training->personal_trainer_id !== auth()->user()->id)
                                        @if ($userPresence && !$userPresenceFalse && !$isTrainingStarted)
                                            <form id="cancel-form-{{ $training->id }}" action="{{ route('trainings.cancel', $training->id) }}" method="POST" class="inline text-sm">
                                                @csrf
                                                <button type="button"
                                                        class="bg-red-500 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-400 text-sm"
                                                        onclick="confirmCancel({{ $training->id }})">
                                                    <i class="fa-solid fa-x w-4 h-4 mr-2"></i>
                                                    Cancelar Inscrição
                                                </button>
                                            </form>
                                        @elseif(!$userPresenceFalse && !$isTrainingStarted)
                                            @if ($remainingSpots > 0 && $currentDateTime->lt($trainingStartDateTime) && $hasActiveMembership)
                                                <form id="enroll-form-{{ $training->id }}" action="{{ route('trainings.enroll', $training->id) }}" method="POST" class="inline text-sm">
                                                    @csrf
                                                    <button type="button"
                                                            class="dark:bg-lime-400 bg-blue-500 text-white flex items-center px-2 py-1 rounded-md hover:bg-green-400 text-sm"
                                                            onclick="confirmEnroll({{ $training->id }})">
                                                        <i class="fa-solid fa-check w-4 h-4 mr-2"></i>
                                                        Inscrever-me
                                                    </button>
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
            <form id="confirmation-form" method="POST" class="inline">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500">Confirmar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let packDeleted = 0;

    function confirmDelete(id) {
        openModal('Pretende eliminar?', 'Não poderá reverter isso!', `/trainings/${id}`, 'DELETE');
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function closeMembershipModal() {
        document.getElementById('membership-modal').classList.add('hidden');
    }

    function filterPacks() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const packCards = document.querySelectorAll('.pack-card');
        packCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            if (name.includes(searchTerm)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    function navigateToWeek(weekDate) {
        const url = new URL(window.location.href);
        url.searchParams.set('week', weekDate);
        window.location.href = url.toString();
    }

    function confirmEnroll(id) {
        openModal('Pretende inscrever-se?', '', `/trainings/${id}/enroll`, 'POST');
    }

    function confirmCancel(id) {
        openModal('Pretende cancelar a inscrição?', '', `/trainings/${id}/cancel`, 'POST');
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
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('input', filterPacks);
        }

        @if($showMembershipModal)
        document.getElementById('membership-modal').classList.remove('hidden');
        @endif
    });
</script>
