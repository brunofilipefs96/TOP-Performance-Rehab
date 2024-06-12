<!-- In your list-trainings.blade.php -->

<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Treinos</h1>
    <div class="mb-10 flex justify-between items-center">
        @can('create', App\Models\Training::class)
            <a href="{{ route('trainings.create') }}">
                <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 font-semibold dark:hover:bg-lime-400 dark:hover:text-gray-800">Adicionar Treino</button>
            </a>
        @endcan
    </div>
    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div id="trainings-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($trainings as $training)
            @php
                $userPresence = $training->users()->where('user_id', auth()->id())->exists();
                $userPresenceFalse = $training->users()->where('user_id', auth()->id())->wherePivot('presence', false)->exists();
            @endphp
            <div class="training-card relative dark:bg-gray-800 bg-gray-400 rounded-lg overflow-hidden shadow-md text-white select-none">
                @if ($userPresence && !$userPresenceFalse)
                    <div class="ribbon"><span>Inscrito</span></div>
                @endif
                <div class="p-4 dark:bg-gray-800 bg-gray-400">
                    <h3 class="text-xl font-semibold mb-2 text-gray-100">{{ $training->trainingType->name }}</h3>

                    <div class="dark:text-gray-400 text-gray-700 mb-2 flex items-center">
                        <svg class="fill-gray-700 dark:fill-gray-400 w-4 h-4 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                        <span>{{ $training->room->name }}</span>
                    </div>
                    <div class="dark:text-gray-400 text-gray-700 mb-2 flex items-center">
                        <svg class="fill-gray-700 dark:fill-gray-400 w-4 h-4 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                        <span>{{ \Carbon\Carbon::parse($training->start_date)->format('d/m/Y') }}</span>
                    </div>
                    <div class="dark:text-gray-400 text-gray-700 mb-2 flex items-center">
                        <svg class="fill-gray-700 dark:fill-gray-400 w-4 h-4 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
                        <span>{{ \Carbon\Carbon::parse($training->start_date)->format('H:i') }}</span>
                    </div>
                    <div class="dark:text-gray-400 text-gray-700 mb-2 flex items-center">
                        <svg class="fill-gray-700 dark:fill-gray-400 w-4 h-4 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 24C0 10.7 10.7 0 24 0H360c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V67c0 40.3-16 79-44.5 107.5L225.9 256l81.5 81.5C336 366 352 404.7 352 445v19h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24s10.7-24 24-24h8V445c0-40.3 16-79 44.5-107.5L158.1 256 76.5 174.5C48 146 32 107.3 32 67V48H24C10.7 48 0 37.3 0 24zM110.5 371.5c-3.9 3.9-7.5 8.1-10.7 12.5H284.2c-3.2-4.4-6.8-8.6-10.7-12.5L192 289.9l-81.5 81.5zM284.2 128C297 110.4 304 89 304 67V48H80V67c0 22.1 7 43.4 19.8 61H284.2z"/></svg>
                        <span>{{ \Carbon\Carbon::parse($training->start_date)->diffInMinutes(\Carbon\Carbon::parse($training->end_date)) }} min.</span>
                    </div>



                    <div class="dark:text-gray-400 text-gray-700 mb-5 flex items-center">
                        <svg class="fill-gray-700 dark:fill-gray-400 w-4 h-4 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                        @php
                            $remainingSpots = $training->max_students - $training->users()->wherePivot('presence', true)->count();
                        @endphp
                        Inscrições: {{ $training->users()->wherePivot('presence', true)->count() }}/{{ $training->max_students }}
                        @if ($remainingSpots > 0)
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full ml-2" title="Vagas disponíveis"></span>
                        @else
                            <span class="inline-block w-3 h-3 bg-red-500 rounded-full ml-2" title="Cheio"></span>
                        @endif
                    </div>
                    @if ($userPresence && $userPresenceFalse)
                        <p class="text-red-500 mb-5">Cancelou a inscrição com menos de 12 horas de antecedência. Não pode voltar a inscrever-se.</p>
                    @endif
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('trainings.show', $training->id) }}" class="bg-blue-400 dark:bg-gray-400 text-white dark:text-gray-800 px-2 py-1 rounded-md hover:bg-blue-300 dark:hover:bg-gray-300">Detalhes</a>
                        @can('update', $training)
                            <a href="{{ route('trainings.edit', $training->id) }}" class="bg-blue-500 dark:bg-gray-500 text-white dark:text-gray-800 px-2 py-1 rounded-md hover:bg-blue-400 dark:hover:bg-gray-400">Editar</a>
                        @endcan
                        @can('delete', $training)
                            <form id="delete-form-{{ $training->id }}" action="{{ route('trainings.destroy', $training->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500" onclick="confirmDelete({{ $training->id }})">Eliminar</button>
                            </form>

                            <div id="confirmation-modal-{{ $training->id }}" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
                                <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
                                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
                                    <p class="mb-4 text-red-500 dark:text-red-300">Não poderá reverter isso!</p>
                                    <div class="flex justify-end gap-4">
                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelDelete({{ $training->id }})">Cancelar</button>
                                        <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500" onclick="confirmDeleteSubmit({{ $training->id }})">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @if (auth()->check() && auth()->user()->cannot('update', $training) && auth()->user()->cannot('delete', $training) && $training->personal_trainer_id !== auth()->user()->id)
                            @if ($userPresence && !$userPresenceFalse)
                                <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-400" onclick="confirmCancel({{ $training->id }})">Cancelar Inscrição</button>
                            @elseif(!$userPresenceFalse)
                                @if ($remainingSpots > 0)
                                    <button type="button" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-400" onclick="confirmEnroll({{ $training->id }})">Inscrever</button>
                                @endif
                            @endif

                            <div id="cancel-modal-{{ $training->id }}" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
                                <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
                                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende cancelar a inscrição?</h2>
                                    <p class="mb-4 text-red-500 dark:text-red-300" id="cancel-message-{{ $training->id }}"></p>
                                    <div class="flex justify-end gap-4">
                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelCancel({{ $training->id }})">Cancelar</button>
                                        <form id="cancel-form-{{ $training->id }}" action="{{ route('trainings.cancel', $training->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Confirmar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="enroll-modal-{{ $training->id }}" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
                                <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
                                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende inscrever-se?</h2>
                                    <div class="flex justify-end gap-4">
                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelEnroll({{ $training->id }})">Cancelar</button>
                                        <form id="enroll-form-{{ $training->id }}" action="{{ route('trainings.enroll', $training->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500">Inscrever</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $trainings->links() }}
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

    function cancelCancel(id) {
        document.getElementById(`cancel-modal-${id}`).classList.add('hidden');
    }
</script>
