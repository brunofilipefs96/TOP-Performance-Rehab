<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 text-gray-800 dark:text-gray-200">Lista de Utilizadores</h1>
    @can('viewAny', App\Models\User::class)
        <div class="mb-10 flex justify-between items-center">
            <div class="relative w-1/3">
                <i class="fa-solid fa-magnifying-glass absolute w-5 h-5 left-3 top-1/2 transform -translate-y-1/2 text-black dark:text-white"></i>
                <input type="text" id="search" placeholder="Pesquisar utilizador..." class="w-full p-2 pl-10 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
            </div>
            <div class="ml-4">
                <select id="role-filter" class="bg-white text-black px-4 py-2 rounded-md border border-gray-300 dark:bg-gray-600 dark:text-white focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
                    <option value="all">Todos</option>
                    <option value="employee">Funcionário</option>
                    <option value="client">Cliente</option>
                    <option value="personal_trainer">Personal Trainer</option>
                </select>
            </div>
        </div>
    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        @foreach ($users as $user)
            @if (!$user->hasRole('admin'))
                @php
                    $userRole = $user->roles->pluck('name')->first();
                    $roleName = $userRole;
                    if ($userRole === 'client') {
                        $roleName = '<i class="fa-solid fa-id-card-clip mr-1"></i>Cliente';
                    } elseif ($userRole === 'employee') {
                        $roleName = '<i class="fa-solid fa-id-card-clip mr-1"></i>Funcionário';
                    } elseif ($userRole === 'personal_trainer') {
                        $roleName = '<i class="fa-solid fa-id-card-clip mr-1"></i>Personal Trainer';
                    }
                @endphp
                <div class="dark:bg-gray-800 bg-gray-500 rounded-lg overflow-hidden shadow-md text-white select-none user-card transform transition-transform duration-300 hover:scale-105 cursor-pointer flex flex-col justify-between" data-name="{{ $user->firstLastName() }}" data-role="{{ $userRole }}" data-nif="{{ $user->nif }}" onclick="location.href='{{ url('users/' . $user->id) }}'">
                    <div class="flex justify-center mt-4">
                        @if($user->image && file_exists(public_path('storage/' . $user->image)))
                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->firstLastName() }}" class="w-24 h-24 object-cover rounded-full border-2 border-gray-300">
                        @else
                            <div class="w-24 h-24 bg-gray-300 dark:bg-gray-600 flex items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-600">
                                <i class="fa-solid fa-user text-4xl text-gray-800 dark:text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 bg-gray-500 dark:bg-gray-800 flex-grow text-left">
                        <h3 class="text-lg font-semibold mb-2 text-center">{{ $user->firstLastName() }}</h3>
                        <p class="text-gray-300 mb-2 mt-6 ml-3">NIF: {{ $user->nif }}</p>
                        <p class="text-gray-300 mb-2 ml-3">{!! $roleName !!}</p>
                        <div class="flex justify-end items-center mt-6 gap-2" onclick="event.stopPropagation();">
                            @can('update', $user)
                                <a href="{{ url('users/' . $user->id . '/edit') }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-700 dark:bg-gray-500 dark:hover:bg-gray-400 flex items-center">
                                    <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>Editar
                                </a>
                            @endcan
                            @can('delete', $user)
                                <form id="delete-form-{{$user->id}}" action="{{ url('users/' . $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="bg-red-600 rounded-md text-white px-2 py-1 hover:bg-red-500 flex items-center mt-2" id="delete-button" onclick="confirmarEliminacao({{ $user->id }})">
                                        <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>Eliminar
                                    </button>
                                </form>

                            @endcan
                        </div>
                    </div>
                </div>
            @endif
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
        {{ $users->links() }}
    </div>
</div>

<script>
    let userDeleted = 0;

    function confirmarEliminacao(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        userDeleted = id;
    }

    document.getElementById('cancel-button').addEventListener('click', function () {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function () {
        document.getElementById(`delete-form-${userDeleted}`).submit();
    });

    let selectedRole = 'all';

    function filterUsers() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const userCards = document.querySelectorAll('.user-card');
        userCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const role = card.getAttribute('data-role').toLowerCase();
            if ((name.includes(searchTerm)) && (selectedRole === 'all' || role === selectedRole)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    document.getElementById('search').addEventListener('input', filterUsers);

    document.getElementById('role-filter').addEventListener('change', function () {
        selectedRole = this.value.toLowerCase();
        filterUsers();
    });
</script>
