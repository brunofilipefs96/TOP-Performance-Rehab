<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Packs</h1>
    @can('create', App\Models\Pack::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ url('packs/create') }}">
                <button type="button"
                        class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 font-semibold dark:hover:bg-lime-400 dark:hover:text-gray-800">
                    Adicionar Pack
                </button>
            </a>
            <input type="text" id="search" placeholder="Pesquisar packs..."
                   class="w-1/3 p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">

        </div>
    @endcan
    <hr class="mb-10 border-gray-400 dark:border-gray-300">
    <h1 class="text-2xl mb-5 mt-10 dark:text-white text-gray-800">Pack Individual</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($packs as $pack)
            @if ($pack->has_personal_trainer == false)
                <div class="pack-card bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none"
                     data-name="{{ $pack->name }}">
                    <div class="p-4 dark:bg-gray-800 bg-gray-400">
                        <h3 class="text-xl font-semibold mb-2">{{ $pack->name }}</h3>
                        <p class="dark:text-gray-400 text-gray-700 mb-2">Quantidade: {{ $pack->trainings_number }}</p>
                        <p class="dark:text-gray-400 text-gray-700 mb-2">Preço: {{ $pack->price }}€</p>
                        <div class="flex justify-end gap-2">
                            <a href="{{ url('packs/' . $pack->id) }}"
                               class="bg-blue-400 dark:text-white px-2 py-1 rounded-md hover:bg-blue-300 dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                            @can('update', $pack)
                                <a href="{{ url('packs/' . $pack->id . '/edit') }}"
                                   class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-400 dark:bg-gray-500 dark:hover:bg-gray-400">Editar</a>
                            @endcan
                            @can('delete', $pack)
                                <form id="delete-form-{{$pack->id}}" action="{{ url('packs/' . $pack->id) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500"
                                            id="delete-button" onclick="confirmarEliminacao({{ $pack->id }})">Eliminar
                                    </button>
                                </form>

                                <div id="confirmation-modal"
                                     class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                    <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende
                                            eliminar?</h2>
                                        <p class="mb-4 dark:text-red-300 text-red-500">Não poderá reverter isso!</p>
                                        <div class="flex justify-end gap-4">
                                            <button id="cancel-button"
                                                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">
                                                Cancelar
                                            </button>
                                            <button id="confirm-button"
                                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">
                                                Eliminar
                                            </button>
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

    <hr class="mt-10 border-gray-800 dark:border-white">

    <h1 class="text-2xl mb-5 mt-10 dark:text-white text-gray-800">Pack com Personal Trainer</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($packs as $pack)
            @if ($pack->has_personal_trainer == true)
                <div class="pack-card bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none"
                     data-name="{{ $pack->name }}">
                    <div class="p-4 dark:bg-gray-800 bg-gray-400">
                        <h3 class="text-xl font-semibold mb-2">{{ $pack->name }}</h3>
                        <p class="dark:text-gray-400 text-gray-700 mb-2">Quantidade: {{ $pack->trainings_number }}</p>
                        <p class="dark:text-gray-400 text-gray-700 mb-2">Preço: {{ $pack->price }}€</p>
                        <div class="flex justify-end items-center mt-4 gap-2">
                            <a href="{{ url('packs/' . $pack->id) }}"
                               class="bg-blue-400 dark:text-white px-2 py-1 rounded-md hover:bg-blue-300 dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                            @can('update', $pack)
                                <a href="{{ url('packs/' . $pack->id . '/edit') }}"
                                   class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-400 dark:bg-gray-500 dark:hover:bg-gray-400">Editar</a>
                            @endcan
                            @can('delete', $pack)
                                <form id="delete-form-{{$pack->id}}" action="{{ url('packs/' . $pack->id) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500"
                                            id="delete-button" onclick="confirmarEliminacao({{ $pack->id }})">Eliminar
                                    </button>
                                </form>

                                <div id="confirmation-modal"
                                     class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                    <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende
                                            eliminar?</h2>
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
            @endif
        @endforeach
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $packs->links() }}
    </div>
</div>

<script>
    let packDeleted = 0;

    function confirmarEliminacao(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        packDeleted = id;
    }

    document.getElementById('cancel-button').addEventListener('click', function () {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function () {
        document.getElementById(`delete-form-${packDeleted}`).submit();
    });

    function filterPacks() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const packCards = document.querySelectorAll('.pack-card');
        packCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            if (name.includes(searchTerm)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    document.getElementById('search').addEventListener('input', filterPacks);
</script>

