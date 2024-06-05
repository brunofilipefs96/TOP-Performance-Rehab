<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 text-gray-800 dark:text-gray-200">Lista de Utilizadores</h1>

    <div class="w-full sm:w-1/2 mb-10 relative">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M18 11a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" id="search" placeholder="Pesquisar por NIF ou Nome Completo" oninput="filterUsers()" class="pl-10 mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
    </div>

    @can('create', App\Models\User::class)
        <a href="{{ url('users/create') }}" class="block mb-4">
            <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-700 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold">Adicionar Utilizador</button>
        </a>
    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($users as $user)
            @if (!$user->hasRole('admin'))
                <div class="dark:bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none user-card" data-name="{{ $user->firstLastName() }}" data-nif="{{ $user->nif }}">
                    <div class="flex justify-center">
                        @if($user->image && file_exists(public_path('storage/' . $user->image)))
                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->firstLastName() }}" class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                <span class="text-3xl">Sem imagem</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 bg-gray-500 dark:bg-gray-800">
                        <h3 class="text-xl font-semibold mb-2">{{ $user->firstLastName() }}</h3>
                        <p class="text-gray-400 mb-2">NIF: {{ $user->nif }}</p>
                        <div class="flex justify-end items-center mt-4 gap-2">
                            <a href="{{ url('users/' . $user->id) }}" class="bg-blue-500 hover:bg-blue-400 text-white px-2 py-1 rounded-md dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                            @can('update', $user)
                                <a href="{{ url('users/' . $user->id . '/edit') }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-700 dark:bg-gray-500 dark:hover:bg-gray-400">Editar</a>
                            @endcan
                            @can('delete', $user)
                                <form id="delete-form-{{$user->id}}" action="{{ url('users/' . $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="bg-red-600 rounded-md  text-white px-2 py-1 -md hover:bg-red-500" id="delete-button" onclick="confirmarEliminacao({{ $user->id }})">Eliminar</button>
                                </form>

                                <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                    <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
                                        <p class="mb-4 dark:text-red-300 text-red-500">Não poderá reverter isso!</p>
                                        <div class="flex justify-end gap-4">
                                            <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                                            <button id="confirm-button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $users->links() }}
    </div>
</div>

<script>
    let userDeleted = 0;

    function confirmarEliminacao(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        userDeleted = id;
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById(`delete-form-${userDeleted}`).submit();
    });

    function filterUsers() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const userCards = document.querySelectorAll('.user-card');
        userCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const nif = card.getAttribute('data-nif').toLowerCase();
            if (name.includes(searchTerm) || nif.includes(searchTerm)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    document.getElementById('search').addEventListener('input', filterUsers);
</script>
