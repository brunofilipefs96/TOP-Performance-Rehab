<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Matrículas</h1>
    <div class="mb-10 flex justify-between items-center">
        <div class="relative w-1/3">
            <form action="{{ route('memberships.index') }}" method="GET">
                <button type="submit" class="absolute w-6 h-6 left-3 top-1/2 transform -translate-y-1/2 text-black dark:text-white">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" id="search" placeholder="Pesquisar matrículas por nome, NIF ou Estado..."
                       class="w-full p-2 pl-10 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
            </form>
        </div>
        <div class="ml-4">
            <form action="{{ route('memberships.index') }}" method="GET" id="filter-form">
                <select name="filter" id="filter" class="bg-white text-black px-4 py-2 rounded-md border border-gray-300 dark:bg-gray-600 dark:text-white" onchange="submitFilterForm()">
                    <option value="all">Todos</option>
                    <option value="active">Ativos</option>
                    <option value="pending">Pendentes</option>
                    <option value="rejected">Rejeitados</option>
                    <option value="frozen">Congelados</option>
                    <option value="pending_payment">Aguardar Pagamento</option>
                </select>
            </form>
        </div>
    </div>
    <hr class="mb-5 border-gray-400 dark:border-gray-300">

    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
            <thead>
            <tr>
                <th class="p-4 text-left">ID</th>
                <th class="p-4 text-left">Nome</th>
                <th class="p-4 text-left">NIF</th>
                <th class="p-4 text-left">Estado</th>
                <th class="p-4 text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($memberships as $membership)
                <tr class="membership-card"
                    data-name="{{ $membership->user->full_name }}"
                    data-nif="{{ $membership->user->nif }}"
                    data-status="{{ $membership->status->name }}">
                    <td class="p-4">{{ $membership->id }}</td>
                    <td class="p-4">{{ $membership->user->full_name }}</td>
                    <td class="p-4">{{ $membership->user->nif }}</td>
                    <td class="p-4">
                        @if($membership->status->name == 'active')
                            <span class="text-green-500">Ativo</span>
                        @elseif($membership->status->name == 'pending')
                            <span class="text-yellow-500">Pendente</span>
                        @elseif($membership->status->name == 'rejected')
                            <span class="text-red-500">Rejeitado</span>
                        @elseif($membership->status->name == 'frozen')
                            <span class="text-blue-500">Congelado</span>
                        @elseif($membership->status->name == 'pending_payment')
                            <span class="text-yellow-500">Aguardar Pagamento</span>
                        @endif
                    </td>
                    <td class="p-4 flex space-x-2 justify-center">
                        <a href="{{ url('memberships/' . $membership->id) }}"
                           class="bg-blue-500 dark:bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:hover:bg-lime-400">Mostrar</a>
                        @can('delete', $membership)
                            <form id="delete-form-{{ $membership->id }}"
                                  action="{{ url('memberships/' . $membership->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-400"
                                        id="delete-button" onclick="confirmarEliminacao({{ $membership->id }})">Eliminar
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
        {{ $memberships->links() }}
    </div>
</div>

<script>
    function submitFilterForm() {
        document.getElementById('filter-form').submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get('filter') || 'all';
        document.getElementById('filter').value = filter;
    });

    let membershipDeleted = 0;

    function confirmarEliminacao(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        membershipDeleted = id;
    }

    document.getElementById('cancel-button').addEventListener('click', function () {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function () {
        document.getElementById('delete-form-' + membershipDeleted).submit();
    });

    function filterPacks() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const selectedStatus = document.getElementById('filter').value;
        const membershipCards = document.querySelectorAll('.membership-card');

        membershipCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const nif = card.getAttribute('data-nif').toLowerCase();
            const status = card.getAttribute('data-status').toLowerCase();

            const matchesSearchTerm = name.includes(searchTerm) || nif.includes(searchTerm) || status.includes(searchTerm);
            const matchesStatus = selectedStatus === 'all' || status === selectedStatus;

            if (matchesSearchTerm && matchesStatus) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    document.getElementById('search').addEventListener('input', filterPacks);
    document.getElementById('filter').addEventListener('change', filterPacks);
</script>
