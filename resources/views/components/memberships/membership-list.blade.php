<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Matrículas</h1>
        <div class="mb-10 flex justify-between items-center">
            <input type="text" id="search" placeholder="Pesquisar matrículas por nome ou NIF..."
                   class="w-1/3 p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
            <div class="ml-4">
                <select id="filter" class="bg-white text-black px-4 py-2 rounded-md border border-gray-300 dark:bg-gray-600 dark:text-white">
                    <option value="all">Todos</option>
                    <option value="active">Ativos</option>
                    <option value="pending">Pendentes</option>
                    <option value="rejected">Rejeitados</option>
                    <option value="frozen">Congelados</option>
                </select>
            </div>
        </div>
    <hr class="mt-10 mb-10 border-gray-800 dark:border-white">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($memberships as $membership)
            <div class="membership-card bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none"
                 data-name="{{ $membership->user->full_name }}" data-nif="{{ $membership->user->nif }}" data-status="{{ $membership->status->name }}">
                <div class="p-4 dark:bg-gray-800 bg-gray-400">
                    <h3 class="text-xl font-semibold mb-2">{{ $membership->user->firstLastName() }}</h3>
                    <p class="dark:text-gray-400 text-gray-700 mb-2">ID Cliente: {{ $membership->user->id }}</p>
                    <p class="dark:text-gray-400 text-gray-700 mb-2">Nif: {{ $membership->user->nif }}</p>
                    <div class="flex items-center mb-2">
                        @if($membership->status->name == 'active')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Ativo</p>
                            <span class="h-3 w-3 bg-green-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'pending')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Pendente</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'rejected')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Rejeitado</p>
                            <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'frozen')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Congelado</p>
                            <span class="h-3 w-3 bg-blue-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'pending_payment')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Aguardar Pagamento</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @endif
                    </div>
                    <div class="flex justify-end items-center mt-4 gap-2">
                        <a href="{{ url('memberships/' . $membership->id) }}"
                           class="bg-blue-400 dark:text-white px-2 py-1 rounded-md hover:bg-blue-300 dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                        @can('delete', $membership)
                            <form id="delete-form-{{$membership->id}}"
                                  action="{{ url('memberships/' . $membership->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500"
                                        id="delete-button" onclick="confirmarEliminacao({{ $membership->id }})">Eliminar
                                </button>
                            </form>

                            <div id="confirmation-modal"
                                 class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
                                    <p class="mb-4 dark:text-red-300 text-red-500">Não poderá reverter isso!</p>
                                    <div class="flex justify-end gap-4">
                                        <button id="cancel-button"
                                                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">
                                            Cancelar
                                        </button>
                                        <button id="confirm-button"
                                                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-300">
                                            Eliminar
                                        </button>
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
        {{ $memberships->links() }}
    </div>
</div>

<script>
    let membershipDeleted = 0;

    function confirmarEliminacao(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        membershipDeleted = id;
    }

    document.getElementById('cancel-button').addEventListener('click', function () {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function () {
        document.getElementById(`delete-form-${membershipDeleted}`).submit();
    });

    function filterPacks() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const selectedStatus = document.getElementById('filter').value;
        const membershipCards = document.querySelectorAll('.membership-card');

        membershipCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const nif = card.getAttribute('data-nif').toLowerCase();
            const status = card.getAttribute('data-status').toLowerCase();

            const matchesSearchTerm = name.includes(searchTerm) || nif.includes(searchTerm);
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
