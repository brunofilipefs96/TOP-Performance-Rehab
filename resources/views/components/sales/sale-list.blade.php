<div class="container mx-auto mt-5">
    @if(Auth::user()->hasRole('admin'))
        <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Vendas</h1>

        <div class="flex flex-wrap justify-between mb-4">
            <div class="w-full sm:w-1/2 lg:w-1/3 mb-2">
                <select id="status-filter" class="w-full p-2 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:text-white dark:bg-gray-700" onchange="filterStatus()">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Todos</option>
                    <option value="pending_payment" {{ $status === 'pending_payment' ? 'selected' : '' }}>A aguardar pagamento</option>
                    <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>Pago</option>
                    <option value="canceled" {{ $status === 'canceled' ? 'selected' : '' }}>Cancelado</option>
                    <option value="delivered" {{ $status === 'delivered' ? 'selected' : '' }}>Entregue</option>
                    <option value="returned" {{ $status === 'returned' ? 'selected' : '' }}>Devolvido</option>
                    <option value="refunded" {{ $status === 'refunded' ? 'selected' : '' }}>Reembolsado</option>
                </select>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/3 mb-2 relative">
                <input type="text" id="nif-search" placeholder="Pesquisar por NIF..." class="w-full p-2 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:text-white dark:bg-gray-700 pr-10" value="{{ $nif }}">
                <button id="search-button" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-800 dark:text-white">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    @else
        <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">O Meu Histórico de Compras</h1>
    @endif
    <hr class="mb-5 border-gray-400 dark:border-gray-300">

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
                <thead>
                <tr>
                    <th class="p-4 text-left">ID</th>
                    @if(Auth::user()->hasRole('admin'))
                        <th class="p-4 text-left">Utilizador</th>
                    @endif
                    <th class="p-4 text-left">NIF</th>
                    <th class="p-4 text-left">Data/Hora</th>
                    <th class="p-4 text-left">Total</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-left">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td class="p-4">{{ $sale->id }}</td>
                        @if(Auth::user()->hasRole('admin'))
                            <td class="p-4">{{ $sale->user->full_name }}</td>
                        @endif
                        <td class="p-4">{{ $sale->nif }}</td>
                        <td class="p-4">{{ $sale->created_at }}</td>
                        <td class="p-4">{{ number_format($sale->total, 2) }} €</td>
                        <td class="p-4">{{ $sale->translated_status }}</td>
                        <td class="p-4">
                            <a href="{{ route('sales.show', $sale->id) }}"
                               class="bg-blue-500 dark:bg-lime-500 text-white px-2 py-1 rounded-md hover:bg-blue-400 dark:hover:bg-lime-400">Ver</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $sales->appends(['status' => $status, 'nif' => $nif])->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('nif-search');
        const searchButton = document.getElementById('search-button');
        const statusFilter = document.getElementById('status-filter');

        if (searchInput && searchButton) {
            searchButton.addEventListener('click', function () {
                searchNif();
            });

            function searchNif() {
                const nif = searchInput.value;
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('nif', nif);
                window.location.search = urlParams.toString();
            }
        }

        if (statusFilter) {
            statusFilter.addEventListener('change', function () {
                filterStatus();
            });

            function filterStatus() {
                const status = statusFilter.value;
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('status', status);
                window.location.search = urlParams.toString();
            }
        }
    });
</script>
