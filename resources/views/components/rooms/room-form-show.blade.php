<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('rooms.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center">
                <h1 class="mb-8 mt-4 dark:text-lime-400 text-gray-800 font-semibold">Sala {{ $room->id }}</h1>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-800 dark:text-white">Nome</label>
                <input type="text" value="{{ $room->name }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="capacity" class="block text-gray-800 dark:text-white">Capacidade</label>
                <input class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $room->capacity }}" disabled>
            </div>

            @can('update', $room)
                <div class="flex justify-end items-center mb-4 mt-10">
                    <a href="{{ url('rooms/' . $room->id . '/edit') }}" class="bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400 mr-2">
                        <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                        Editar
                    </a>
                    @can('delete', $room)
                        <form id="delete-form-{{$room->id}}" action="{{ url('rooms/' . $room->id) }}" method="POST" class="inline mr-2">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500" id="delete-button" onclick="confirmDelete({{ $room->id }})">
                                <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            @endcan
        </div>
    </div>
</div>

<div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelAction()">Cancelar</button>
            <form id="confirmation-form" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500">Confirmar</button>
            </form>
        </div>
    </div>
</div>

<script>
    let roomDeleted = 0;

    function confirmDelete(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        roomDeleted = id;
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById(`delete-form-${roomDeleted}`).submit();
    });
</script>
