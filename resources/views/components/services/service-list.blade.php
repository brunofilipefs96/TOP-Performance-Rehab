<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Servico</h1>
    @can('create', App\Models\Service::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ route('services.create') }}">
                <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 font-semibold dark:hover:bg-lime-400 dark:hover:text-gray-800">Adicionar Servico</button>
            </a>
            <input type="date" id="search-date" class="w-1/3 p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50" value="{{ \Carbon\Carbon::now()->toDateString() }}">
        </div>
        <hr class="mb-10 border-gray-400 dark:border-gray-300">
    @endcan
    <div id="trainings-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($services as $service)
            <div class="service.card relative dark:bg-gray-800 bg-gray-400 rounded-lg overflow-hidden shadow-md text-white select-none" data-date="{{ \Carbon\Carbon::parse($service->start_date)->toDateString() }}" data-start-time="{{ \Carbon\Carbon::parse($service->start_date)->format('H:i') }}">
                @if ($service->users->contains(auth()->user()))
                    <div class="ribbon"><span>Inscrito</span></div>
                @endif
                <div class="p-4 dark:bg-gray-800 bg-gray-400">
                    <h3 class="text-xl font-semibold mb-2 text-gray-100">{{ $service->name }}</h3>
                    <p class="dark:text-gray-400 text-gray-700 mb-2">Sala: {{ $service->room->name }}</p>
                    <p class="dark:text-gray-400 text-gray-700 mb-2">Data: {{ \Carbon\Carbon::parse($service->start_date)->format('d/m/Y') }}</p>
                    <p class="dark:text-gray-400 text-gray-700 mb-2">Hora de Início: {{ \Carbon\Carbon::parse($service->start_date)->format('H:i') }}</p>
                    <p class="dark:text-gray-400 text-gray-700 mb-5">Duração: {{ \Carbon\Carbon::parse($service->start_date)->diffInMinutes(\Carbon\Carbon::parse($service->end_date)) }} minutos</p>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('trainings.show', $service->id) }}" class="bg-blue-400 dark:bg-gray-400 text-white dark:text-gray-800 px-2 py-1 rounded-md hover:bg-blue-300 dark:hover:bg-gray-300">Mostrar</a>
                        @can('update', $service)
                            <a href="{{ route('trainings.edit', $service->id) }}" class="bg-blue-500 dark:bg-gray-500 text-white dark:text-gray-800 px-2 py-1 rounded-md hover:bg-blue-400 dark:hover:bg-gray-400">Editar</a>
                        @endcan
                        @can('delete', $service)
                            <form id="delete-form-{{ $service->id }}" action="{{ route('trainings.destroy', $service->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500" onclick="confirmDelete({{ $service->id }})">Eliminar</button>
                            </form>

                            <div id="confirmation-modal-{{ $service->id }}" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
                                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
                                    <p class="mb-4 text-red-500 dark:text-red-300">Não poderá reverter isso!</p>
                                    <div class="flex justify-end gap-4">
                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelDelete({{ $service->id }})">Cancelar</button>
                                        <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500" onclick="confirmDeleteSubmit({{ $service->id }})">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @if (auth()->check() && auth()->user()->cannot('update', $service) && auth()->user()->cannot('delete', $service) && $service->personal_trainer_id !== auth()->user()->id && !$service->users->contains(auth()->user()))
                            @if ($remainingSpots > 0)
                                <button type="button" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-400" onclick="confirmEnroll({{ $service->id }})">Inscrever</button>
                            @endif

                            <div id="enroll-modal-{{ $service->id }}" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
                                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende inscrever-se?</h2>
                                    <div class="flex justify-end gap-4">
                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelEnroll({{ $service->id }})">Cancelar</button>
                                        <form id="enroll-form-{{ $service->id }}" action="{{ route('trainings.enroll', $service->id) }}" method="POST" class="inline">
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
        {{ $services->links() }}
    </div>
</div>

<script>
    let serviceDeleted = 0;
    let serviceEnrolled = 0;

    function confirmDelete(id) {
        document.getElementById(`confirmation-modal-${id}`).classList.remove('hidden');
        serviceDeleted = id;
    }

    function cancelDelete(id) {
        document.getElementById(`confirmation-modal-${id}`).classList.add('hidden');
    }

    function confirmDeleteSubmit(id) {
        document.getElementById(`delete-form-${id}`).submit();
    }

    function confirmEnroll(id) {
        document.getElementById(`enroll-modal-${id}`).classList.remove('hidden');
        serviceEnrolled = id;
    }

    function cancelEnroll(id) {
        document.getElementById(`enroll-modal-${id}`).classList.add('hidden');
    }

    function filterServices() {
        const searchDate = document.getElementById('search-date').value;
        const serviceCards = document.querySelectorAll('.service.card');
        serviceCards.forEach(card => {
            const date = card.getAttribute('data-date');
            if (date === searchDate) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
        sortServices();
    }

    function sortServices() {
        const container = document.getElementById('trainings-container');
        const cards = Array.from(container.querySelectorAll('.service.card')).filter(card => !card.classList.contains('hidden'));

        cards.sort((a, b) => {
            const timeA = a.getAttribute('data-start-time');
            const timeB = b.getAttribute('data-start-time');
            return timeA.localeCompare(timeB);
        });

        cards.forEach(card => container.appendChild(card));
    }

    document.getElementById('search-date').addEventListener('input', filterServices);

    document.addEventListener('DOMContentLoaded', filterServices);
</script>
