<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 text-white">Lista de Utilizadores</h1>
    @can('create', App\Models\User::class)
        <a href="{{ url('users/create') }}" class="block mb-4">
            <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-700 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold">Adicionar Utilizador</button>
        </a>
    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($users as $user)
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none">
                <div class="flex justify-center">
                    @if($user->image && file_exists(public_path($user->image)))
                        <img src="{{ asset($user->image) }}" alt="{{ $user->firstLastName() }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-600 flex items-center justify-center">
                            <span class="text-3xl">Sem imagem</span>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $user->firstLastName() }}</h3>
                    <p class="text-gray-400 mb-2">NIF: {{ $user->nif }}</p>
                    <div class="flex justify-end items-center mt-4 gap-2">
                        <a href="{{ url('users/' . $user->id) }}" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-700 dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                        @can('update', $user)
                            <a href="{{ url('users/' . $user->id . '/edit') }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-700 dark:bg-gray-500 dark:hover:bg-gray-400">Editar</a>
                        @endcan
                        @can('delete', $user)
                            <form id="delete-form-user" action="{{ url('users/' . $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-button-user bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-700 bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500">Eliminar</button>
                            </form>

                            <div id="confirmation-modal-user" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                <div class="bg-white p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                    <h2 class="text-xl font-bold mb-4">Pretende eliminar?</h2>
                                    <p class="mb-4">Não poderá reverter isso!</p>
                                    <div class="flex justify-end gap-4">
                                        <button id="cancel-button-user" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                                        <button id="confirm-button-user" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $users->links() }}
    </div>
</div>

<script>
    const deleteButtonUser = document.querySelector('.delete-button-user');
    const confirmationModalUser = document.querySelector('#confirmation-modal-user');
    const cancelButtonUser = document.querySelector('#cancel-button-user');
    const confirmButtonUser = document.querySelector('#confirm-button-user');

    deleteButtonUser.addEventListener('click', function() {
        confirmationModalUser.classList.remove('hidden');
    });

    cancelButtonUser.addEventListener('click', function() {
        confirmationModalUser.classList.add('hidden');
    });

    confirmButtonUser.addEventListener('click', function() {
        document.getElementById('delete-form-user').submit();
    });
</script>
