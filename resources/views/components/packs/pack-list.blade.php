<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Packs</h1>
    @can('create', App\Models\Pack::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ url('packs/create') }}">
                <button type="button"
                        class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 font-semibold dark:hover:bg-lime-400 dark:hover:text-gray-800 flex items-center">
                    <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
                    Adicionar Pack
                </button>
            </a>
            <div class="relative w-1/3">
                <i class="fa-solid fa-magnifying-glass absolute w-5 h-5 left-3 top-1/2 transform -translate-y-1/2 text-black dark:text-white"></i>
                <input type="text" id="search" placeholder="Pesquisar packs..."
                       class="w-full p-2 pl-10 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
            </div>
        </div>
    @endcan
    <hr class="mb-10 border-gray-400 dark:border-gray-300">
    <h1 class="text-2xl mb-5 mt-10 dark:text-white text-gray-800">Pack Individual</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($packs as $pack)
            @if ($pack->has_personal_trainer == false)
                <div class="pack-card bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105 cursor-pointer flex flex-col justify-between"
                     data-name="{{ $pack->name }}"
                     onclick="location.href='{{ url('packs/' . $pack->id) }}'">
                    <div class="p-4 dark:bg-gray-800 bg-gray-400 flex-grow">
                        <h3 class="text-xl font-semibold mb-2"><i class="fa-solid fa-box w-5 h-5 mr-2"></i>{{ $pack->name }}</h3>
                        <p class="dark:text-gray-400 text-gray-700 mb-2"><i class="fa-solid fa-hourglass-half w-5 h-5 mr-2"></i>{{ $pack->duration }} Dias</p>
                        <p class="dark:text-gray-400 text-gray-700 mb-2"><i class="fa-regular fa-calendar-check w-5 h-5 mr-2"></i>Treinos: {{ $pack->trainings_number }}</p>
                        <p class="dark:text-gray-400 text-gray-700 mb-2"><i class="fa-solid fa-coins w-5 h-5 mr-2"></i>Preço: {{ $pack->price }}€</p>
                    </div>
                    <div class="flex justify-end gap-2 p-4" onclick="event.stopPropagation();">
                        @can('update', $pack)
                            <a href="{{ url('packs/' . $pack->id . '/edit') }}"
                               class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-400 dark:bg-gray-500 dark:hover:bg-gray-400 flex items-center">
                                <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>Editar
                            </a>
                        @endcan
                        @can('delete', $pack)
                            <form id="delete-form-{{$pack->id}}" action="{{ url('packs/' . $pack->id) }}"
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500 flex items-center"
                                        id="delete-button" onclick="confirmarEliminacao({{ $pack->id }})">
                                    <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>Eliminar
                                </button>
                            </form>
                        @endcan
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
                <div class="pack-card bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105 cursor-pointer flex flex-col justify-between"
                     data-name="{{ $pack->name }}"
                     onclick="location.href='{{ url('packs/' . $pack->id) }}'">
                    <div class="p-4 dark:bg-gray-800 bg-gray-400 flex-grow">
                        <h3 class="text-xl font-semibold mb-2"><i class="fa-solid fa-box w-5 h-5 mr-2"></i>{{ $pack->name }}</h3>
                        <p class="dark:text-gray-400 text-gray-700 mb-2"><i class="fa-solid fa-calendar w-5 h-5 mr-2"></i>Duração: {{ $pack->duration }} dias</p>
                        <p class="dark:text-gray-400 text-gray-700 mb-2"><i class="fa-solid fa-dumbbell w-5 h-5 mr-2"></i>Quantidade: {{ $pack->trainings_number }}</p>
                        <p class="dark:text-gray-400 text-gray-700 mb-2"><i class="fa-solid fa-euro-sign w-5 h-5 mr-2"></i>Preço: {{ $pack->price }}€</p>
                    </div>
                    <div class="flex justify-end items-center gap-2 p-4" onclick="event.stopPropagation();">
                        @can('update', $pack)
                            <a href="{{ url('packs/' . $pack->id . '/edit') }}"
                               class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-400 dark:bg-gray-500 dark:hover:bg-gray-400 flex items-center">
                                <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>Editar
                            </a>
                        @endcan
                        @can('delete', $pack)
                            <form id="delete-form-{{$pack->id}}" action="{{ url('packs/' . $pack->id) }}"
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500 flex items-center"
                                        id="delete-button" onclick="confirmarEliminacao({{ $pack->id }})">
                                    <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>Eliminar
                                </button>
                            </form>
                        @endcan
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
