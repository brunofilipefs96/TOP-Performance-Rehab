<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Seguros</h1>
    <div class="mb-10 flex justify-between items-center">
        <div class="relative w-1/3">
            <form action="{{ route('insurances.index') }}" method="GET">
                <button type="submit" class="absolute w-6 h-6 left-3 top-1/2 transform -translate-y-1/2 text-black dark:text-white">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" id="search" placeholder="Pesquisar seguros por nome, NIF ou Estado..."
                       class="w-full p-2 pl-10 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
            </form>
        </div>
        <div class="ml-4">
            <form action="{{ route('insurances.index') }}" method="GET" id="filter-form">
                <select name="filter" id="filter" class="bg-white text-black px-4 py-2 rounded-md border border-gray-300 dark:bg-gray-600 dark:text-white" onchange="document.getElementById('filter-form').submit();">
                    <option value="all">Todos</option>
                    <option value="active">Ativos</option>
                    <option value="pending">Pendentes</option>
                    <option value="inactive">Inativos</option>
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
            @foreach($insurances as $insurance)
                @php
                    $user = optional($insurance->membership)->user;
                @endphp
                <tr class="insurance-card"
                    data-name="{{ $user ? $user->full_name : 'N/A' }}"
                    data-nif="{{ $user ? $user->nif : 'N/A' }}"
                    data-status="{{ $insurance->status->name }}">
                    <td class="p-4">{{ $insurance->id }}</td>
                    <td class="p-4">{{ $user ? $user->full_name : 'N/A' }}</td>
                    <td class="p-4">{{ $user ? $user->nif : 'N/A' }}</td>
                    <td class="p-4">
                        @if($insurance->status->name == 'active')
                            <span class="text-green-500">Ativo</span>
                        @elseif(in_array($insurance->status->name, ['pending', 'renew_pending']))
                            <span class="text-yellow-500">Pendente</span>
                        @elseif($insurance->status->name == 'inactive')
                            <span class="text-red-500">Inativo</span>
                        @elseif($insurance->status->name == 'frozen')
                            <span class="text-blue-500">Congelado</span>
                        @elseif(in_array($insurance->status->name, ['pending_payment', 'pending_renewPayment']))
                            <span class="text-yellow-500">Aguardar Pagamento</span>
                        @elseif($insurance->status->name == 'awaiting_membership')
                            <span class="text-yellow-500">Aguarda renovação da matrícula</span>
                        @endif
                    </td>
                    <td class="p-4 flex space-x-2 justify-center">
                        <a href="{{ url('insurances/' . $insurance->id) }}"
                           class="bg-blue-500 dark:bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:hover:bg-lime-400">Mostrar</a>
                        @can('delete', $insurance)
                            <form id="delete-form-{{ $insurance->id }}"
                                  action="{{ url('insurances/' . $insurance->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-400"
                                        id="delete-button" onclick="confirmDelete({{ $insurance->id }})">Eliminar
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
        {{ $insurances->links() }}
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
    function submitFilterForm() {
        document.getElementById('filter-form').submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get('filter') || 'all';
        document.getElementById('filter').value = filter;
    });

    let insuranceDeleted = 0;

    function confirmDelete(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        insuranceDeleted = id;
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function confirmAction() {
        document.getElementById('delete-form-' + insuranceDeleted).submit();
    }

    function filterPacks() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const selectedStatus = document.getElementById('filter').value;
        const insuranceCards = document.querySelectorAll('.insurance-card');

        insuranceCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const nif = card.getAttribute('data-nif').toLowerCase();
            const status = card.getAttribute('data-status').toLowerCase();

            const matchesSearchTerm = name.includes(searchTerm) || nif.includes(searchTerm) || status.includes(searchTerm);
            const matchesStatus = selectedStatus === 'all' || status === selectedStatus ||
                (selectedStatus === 'pending' && ['pending', 'renew_pending'].includes(status)) ||
                (selectedStatus === 'pending_payment' && ['pending_payment', 'pending_renewPayment'].includes(status));

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
