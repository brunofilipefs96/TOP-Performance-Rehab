<!-- In your list-trainings.blade.php -->

<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Treinos</h1>
    @can('create', App\Models\Training::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ route('trainings.create') }}">
                <button type="button"
                        class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center">
                    <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
                    Adicionar Treino
                </button>
            </a>
            <button type="button" onclick="openMultiDeleteModal()" class="bg-red-600 text-white flex items-center px-2 py-2 rounded-md hover:bg-red-500 dark:bg-red-500  dark:hover:text-gray-800 font-semibold ">
                <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                Remover Vários Treinos
            </button>
        </div>
    @endcan
    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div id="trainings-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($trainings as $training)
            @php
                $userPresence = $training->users()->where('user_id', auth()->id())->exists();
                $userPresenceFalse = $training->users()->where('user_id', auth()->id())->wherePivot('presence', false)->exists();
            @endphp
            <div class="training-card relative dark:bg-gray-800 bg-gray-400 rounded-lg overflow-hidden shadow-md text-white select-none" data-id="{{ $training->id }}" data-date="{{ $training->start_date }}" data-start-time="{{ $training->start_time }}">
            <a href="{{ route('trainings.show', $training->id) }}" class="block p-4 dark:bg-gray-800 bg-gray-400">
                    @if ($userPresence && !$userPresenceFalse)
                        <div class="ribbon"><span>Inscrito</span></div>
                    @endif
                    <h3 class="text-xl font-semibold mb-2 text-gray-100">{{ $training->trainingType->name }}</h3>
                    <div class="dark:text-gray-400 text-gray-700 mb-2 flex items-center">
                        <i class="fa-solid fa-user w-4 h-4 mr-2"></i>
                        <span>{{ $training->personalTrainer->firstLastName() }}</span>
                    </div>
                    <div class="dark:text-gray-400 text-gray-700 mb-2 flex items-center">
                        <i class="fa-solid fa-location-dot w-4 h-4 mr-2"></i>
                        <span>{{ $training->room->name }}</span>
                    </div>
                    <div class="dark:text-gray-400 text-gray-700 mb-2 flex items-center">
                        <i class="fa-solid fa-calendar-days w-4 h-4 mr-2"></i>
                        <span>{{ \Carbon\Carbon::parse($training->start_date)->format('d/m/Y') }}</span>
                    </div>
                    <div class="dark:text-gray-400 text-gray-700 mb-2 flex items-center">
                        <i class="fa-solid fa-clock w-4 h-4 mr-2"></i>
                        <span>{{ \Carbon\Carbon::parse($training->start_date)->format('H:i') }}</span>
                    </div>
                    <div class="dark:text-gray-400 text-gray-700 mb-2 flex items-center">
                        <i class="fa-solid fa-hourglass-half w-4 h-4 mr-2"></i>
                        <span>{{ \Carbon\Carbon::parse($training->start_date)->diffInMinutes(\Carbon\Carbon::parse($training->end_date)) }} min.</span>
                    </div>
                    <div class="dark:text-gray-400 text-gray-700 mb-5 flex items-center">
                        <i class="fa-solid fa-square-check w-4 h-4 mr-2"></i>
                        @php
                            $remainingSpots = $training->max_students - $training->users()->wherePivot('presence', true)->count();
                        @endphp
                        Inscrições: {{ $training->users()->wherePivot('presence', true)->count() }}
                        /{{ $training->max_students }}
                        @if ($remainingSpots > 0)
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full ml-2"
                                  title="Vagas disponíveis"></span>
                        @else
                            <span class="inline-block w-3 h-3 bg-red-500 rounded-full ml-2" title="Cheio"></span>
                        @endif
                    </div>
                    @if ($userPresence && $userPresenceFalse)
                        <p class="text-red-500 mb-5">Cancelou a inscrição com menos de 12 horas de antecedência. Não
                            pode voltar a inscrever-se.</p>
                    @endif
                </a>
                <div class="flex flex-wrap justify-end items-center gap-2 p-4">
                    @if (auth()->check() && auth()->user()->cannot('update', $training) && auth()->user()->cannot('delete', $training) && $training->personal_trainer_id !== auth()->user()->id)
                        @if ($userPresence && !$userPresenceFalse)
                            <button type="button"
                                    class="bg-red-500 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-400"
                                    onclick="confirmCancel({{ $training->id }})">
                                <i class="fa-solid fa-x w-4 h-4 mr-2"></i>
                                Cancelar Inscrição
                            </button>
                        @elseif(!$userPresenceFalse)
                            @if ($remainingSpots > 0)
                                <button type="button"
                                        class="dark:bg-lime-400 bg-blue-500 text-white flex items-center px-2 py-1 rounded-md hover:bg-green-400"
                                        onclick="confirmEnroll({{ $training->id }})">
                                    <i class="fa-solid fa-check w-4 h-4 mr-2"></i>
                                    Inscrever-me
                                </button>
                            @endif
                        @endif
                    @endif
                    @can('update', $training)
                        <a href="{{ route('trainings.edit', $training->id) }}"
                           class="bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400">
                            <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                            Editar
                        </a>
                    @endcan
                    @can('delete', $training)
                        <form id="delete-form-{{ $training->id }}"
                              action="{{ route('trainings.destroy', $training->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500"
                                    onclick="confirmDelete({{ $training->id }})">
                                <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                Eliminar
                            </button>
                        </form>

                        <div id="confirmation-modal-{{ $training->id }}"
                             class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
                            <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
                                <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende
                                    eliminar?</h2>
                                <p class="mb-4 text-red-500 dark:text-red-300">Não poderá reverter isso!</p>
                                <div class="flex justify-end gap-4">
                                    <button type="button"
                                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400"
                                            onclick="cancelDelete({{ $training->id }})">Cancelar
                                    </button>
                                    <button type="button"
                                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500"
                                            onclick="confirmDeleteSubmit({{ $training->id }})">Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>

            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $trainings->links() }}
    </div>
</div>

<div id="cancel-modal-{{ $training->id }}"
     class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende cancelar a inscrição?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="cancel-message-{{ $training->id }}"></p>
        <div class="flex justify-end gap-4">
            <button type="button"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400"
                    onclick="cancelCancel({{ $training->id }})">Cancelar
            </button>
            <form id="cancel-form-{{ $training->id }}"
                  action="{{ route('trainings.cancel', $training->id) }}" method="POST" class="inline">
                @csrf
                <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500" onclick="confirmCancelSubmit({{ $training->id }})">
                    Confirmar
                </button>
            </form>
        </div>
    </div>
</div>

<div id="enroll-modal-{{ $training->id }}"
     class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende inscrever-se?</h2>
        <div class="flex justify-end gap-4">
            <button type="button"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400"
                    onclick="cancelEnroll({{ $training->id }})">Cancelar
            </button>
            <form id="enroll-form-{{ $training->id }}"
                  action="{{ route('trainings.enroll', $training->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500">
                    Inscrever
                </button>
            </form>
        </div>
    </div>
</div>

<div id="multi-delete-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Selecione os Treinos para Remover</h2>
        <form id="multi-delete-form" action="{{ route('trainings.multi-delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="max-h-64 overflow-y-auto">
                @foreach ($trainings as $training)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="trainings[]" value="{{ $training->id }}" class="mr-2">
                        <span>{{ $training->trainingType->name }} - {{ $training->start_date }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-end gap-4 mt-4">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="closeMultiDeleteModal()">Cancelar</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Remover Selecionados</button>
            </div>
        </form>
    </div>
</div>



<script>
    let trainingDeleted = 0;
    let trainingEnrolled = 0;
    let trainingCanceled = 0;

    function confirmDelete(id) {
        document.getElementById(`confirmation-modal-${id}`).classList.remove('hidden');
        trainingDeleted = id;
    }

    function cancelDelete(id) {
        document.getElementById(`confirmation-modal-${id}`).classList.add('hidden');
    }

    function confirmDeleteSubmit(id) {
        document.getElementById(`delete-form-${id}`).submit();
    }

    function confirmEnroll(id) {
        document.getElementById(`enroll-modal-${id}`).classList.remove('hidden');
        trainingEnrolled = id;
    }

    function cancelEnroll(id) {
        document.getElementById(`enroll-modal-${id}`).classList.add('hidden');
    }

    function confirmCancel(id) {
        const card = document.querySelector(`.training-card[data-id="${id}"]`);
        const startDate = card.getAttribute('data-date');
        const startTime = card.getAttribute('data-start-time');
        const startDateTime = new Date(`${startDate}T${startTime}:00`);
        const now = new Date();
        const differenceInHours = (startDateTime - now) / 36e5;

        let cancelMessage = 'Atenção! Não será reembolsado e não poderá voltar a inscrever-se neste treino, pois faltam menos de 12 horas até este treino se realizar.';
        if (differenceInHours > 12) {
            cancelMessage = 'Atenção! Não será reembolsado e não poderá voltar a inscrever-se neste treino, pois faltam menos de 12 horas até este treino se realizar.';
        }

        document.getElementById(`cancel-message-${id}`).innerText = cancelMessage;
        document.getElementById(`cancel-modal-${id}`).classList.remove('hidden');
        trainingCanceled = id;
    }

    function confirmCancelSubmit(id) {
        document.getElementById(`cancel-form-${id}`).submit();
    }

    function cancelCancel(id) {
        document.getElementById(`cancel-modal-${id}`).classList.add('hidden');
    }

    function openMultiDeleteModal() {
        document.getElementById('multi-delete-modal').classList.remove('hidden');
    }

    function closeMultiDeleteModal() {
        document.getElementById('multi-delete-modal').classList.add('hidden');
    }

</script>
