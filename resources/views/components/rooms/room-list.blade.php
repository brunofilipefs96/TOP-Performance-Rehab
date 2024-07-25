<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Salas</h1>
    @can('create', App\Models\Room::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ url('rooms/create') }}">
                <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm">
                    <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
                    Adicionar Sala
                </button>
            </a>
            <div class="relative w-1/3">
                <i class="fa-solid fa-magnifying-glass absolute w-5 h-5 left-3 top-1/2 transform -translate-y-1/2 text-black dark:text-white"></i>
                <input type="text" id="search" placeholder="Pesquisar salas..." class="w-full p-2 pl-10 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
            </div>
        </div>
        <hr class="mb-10 border-gray-400 dark:border-gray-300">
    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($rooms as $room)
            <div class="room-card dark:bg-gray-800 bg-gray-500 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105 flex flex-col justify-between cursor-pointer" data-name="{{ $room->name }}" onclick="location.href='{{ url('rooms/' . $room->id) }}'">
                <div class="p-4 dark:bg-gray-800 bg-gray-500 flex-grow">
                    <h3 class="text-lg font-semibold mb-2">{{ $room->name }}</h3>
                    <p class="dark:text-gray-400 text-gray-300"><i class="fa-solid fa-people-group mr-2"></i>Capacidade: {{ $room->capacity }}</p>
                </div>
                <div class="flex justify-end items-center p-4 mt-auto space-x-2" onclick="event.stopPropagation();">
                    @can('update', $room)
                        <a href="{{ url('rooms/' . $room->id . '/edit') }}" class="mt-2 bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400 text-sm">
                            <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                            Editar
                        </a>
                    @endcan
                    @can('delete', $room)
                            <form id="delete-form-{{$room->id}}" action="{{ url('rooms/' . $room->id) }}" method="POST" class="inline" onsubmit="disableConfirmButton(this)">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 rounded-md text-white px-2 py-1 hover:bg-red-500 flex items-center mt-2 h-7" id="delete-button" onclick="confirmarEliminacao({{ $room->id }})">
                                    <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>Eliminar
                                </button>
                            </form>
                    @endcan
                </div>
            </div>
        @endforeach

            <div id="confirmation-modal" class="fixed flex inset-0 items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
                    <p class="mb-4 dark:text-red-300 text-red-500">Não poderá reverter isso!</p>
                    <div class="flex justify-end gap-4">
                        <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                        <button id="confirm-button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Eliminar</button>
                    </div>
                </div>
            </div>
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $rooms->links() }}
    </div>
</div>

<script>
    let roomDeleted = 0;

    function confirmarEliminacao(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        roomDeleted = id;
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById(`delete-form-${roomDeleted}`).submit();
    });

    function filterRooms() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const roomCards = document.querySelectorAll('.room-card');
        roomCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            if (name.includes(searchTerm)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    document.getElementById('search').addEventListener('input', filterRooms);
</script>
