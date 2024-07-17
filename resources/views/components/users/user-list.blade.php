<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 text-gray-800 dark:text-gray-200">Lista de Utilizadores</h1>
    @can('viewAny', App\Models\User::class)
        <div class="mb-10 flex justify-between items-center">
            <div class="relative w-1/3">
                <form action="{{ route('users.index') }}" method="GET" id="search-filter-form" class="flex">
                    <button type="submit" class="absolute w-6 h-6 left-3 top-1/2 transform -translate-y-1/2 text-black dark:text-white">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <input type="text" name="search" id="search" placeholder="Pesquisar utilizador..." class="w-full p-2 pl-10 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50" value="{{ $search ?? '' }}">
                    <select name="role" id="role-filter" class="bg-white text-black px-4 py-2 rounded-md border border-gray-300 dark:bg-gray-600 dark:text-white ml-4" onchange="document.getElementById('search-filter-form').submit();">
                        <option value="all" {{ ($role ?? 'all') == 'all' ? 'selected' : '' }}>Todos</option>
                        <option value="employee" {{ ($role ?? '') == 'employee' ? 'selected' : '' }}>Funcionário</option>
                        <option value="client" {{ ($role ?? '') == 'client' ? 'selected' : '' }}>Cliente</option>
                        <option value="personal_trainer" {{ ($role ?? '') == 'personal_trainer' ? 'selected' : '' }}>Personal Trainer</option>
                        <option value="admin" {{ ($role ?? '') == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </form>
            </div>
        </div>
    @endcan

    <hr class="mb-5 border-gray-400 dark:border-gray-300">

    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
            <thead>
            <tr>
                <th class="p-4 text-left">ID</th>
                <th class="p-4 text-left">Nome</th>
                <th class="p-4 text-left">NIF</th>
                <th class="p-4 text-left">Papel</th>
                <th class="p-4 text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                @php
                    $userRole = $user->roles->pluck('name')->first();
                    $roleName = $userRole;
                    if ($userRole === 'client') {
                        $roleName = '<i class="fa-solid fa-id-card-clip mr-1"></i>Cliente';
                    } elseif ($userRole === 'employee') {
                        $roleName = '<i class="fa-solid fa-id-card-clip mr-1"></i>Funcionário';
                    } elseif ($userRole === 'personal_trainer') {
                        $roleName = '<i class="fa-solid fa-id-card-clip mr-1"></i>Personal Trainer';
                    } elseif ($userRole === 'admin') {
                        $roleName = '<i class="fa-solid fa-id-card-clip mr-1"></i>Administrador';
                    }
                @endphp
                <tr class="user-card"
                    data-name="{{ $user->firstLastName() }}"
                    data-nif="{{ $user->nif }}"
                    data-role="{{ $userRole }}">
                    <td class="p-4">{{ $user->id }}</td>
                    <td class="p-4">{{ $user->firstLastName() }}</td>
                    <td class="p-4">{{ $user->nif }}</td>
                    <td class="p-4">{!! $roleName !!}</td>
                    <td class="p-4 flex space-x-2 justify-center">
                        <a href="{{ url('users/' . $user->id) }}"
                           class="bg-blue-500 dark:bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:hover:bg-lime-400">Mostrar</a>
                        @can('delete', $user)
                            <form id="delete-form-{{ $user->id }}"
                                  action="{{ url('users/' . $user->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-400"
                                        id="delete-button" onclick="confirmDelete({{ $user->id }})">Eliminar
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $users->appends(request()->input())->links() }}
    </div>
</div>

<!-- Modal de confirmação de eliminação -->
<div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelAction()">Cancelar</button>
            <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500" onclick="confirmAction()">Confirmar</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('role-filter').addEventListener('change', function () {
        document.getElementById('search-filter-form').submit();
    });

    let userDeleted = 0;

    function confirmDelete(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        userDeleted = id;
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function confirmAction() {
        document.getElementById('delete-form-' + userDeleted).submit();
    }
</script>
