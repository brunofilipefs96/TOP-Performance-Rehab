@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    if($user->membership) {
        $myPacks = $user->membership->packs;
        }
@endphp
<div class="container mx-auto mt-5 mb-10">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Packs</h1>

    @can('create', App\Models\Pack::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ url('packs/create') }}">
                <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm">
                    <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
                    Adicionar Pack
                </button>
            </a>
        </div>
    @endcan
    <hr class="mb-10 border-gray-400 dark:border-gray-300">
    @if(Auth::check() && Auth::user()->hasRole('client'))
        <h1 class="text-2xl mb-5 mt-10 dark:text-white text-gray-800">Seus packs disponíveis</h1>

        @if($user->membership && count($myPacks) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
            @foreach($myPacks as $pack)
                @if($pack->pivot->expiry_date > Carbon::today())
                    <div class="pack-card dark:bg-gray-800 bg-gray-500 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105 flex flex-col justify-between cursor-pointer" data-name="{{ $pack->name }}" onclick="location.href='{{ url('packs/' . $pack->id) }}'">
                        <div class="p-4 dark:bg-gray-800 bg-gray-500 flex-grow">
                            <h3 class="text-lg font-semibold mb-2"><i class="fa-solid fa-box w-5 h-5 mr-2"></i>{{ $pack->name }}</h3>
                            <p class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                                <i class="fa-solid fa-hourglass-half w-4 h-4 mr-2"></i>
                                <span>{{ $pack->duration }} Dias</span>
                            </p>
                            <p class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                                <i class="fa-solid fa-dumbbell w-4 h-4 mr-2"></i>
                                <span>{{ $pack->trainings_number }} Treinos</span>
                            </p>
                            <p class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                                <i class="fa-solid fa-dumbbell w-4 h-4 mr-2"></i>
                                <span>{{ $pack->pivot->quantity_remaining }} restantes</span>
                            </p>
                            <p class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">

                                <span>Válidade: {{ Carbon::parse($pack->pivot->expiry_date)->format('d/m/Y') }}</span>
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
            </div>
        @else
            <p class="mb-10">Não possui treinos disponíveis vá a loja para adiquirir novos packs</p>
        @endif
    @endif
    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div class="mb-10 flex justify-between items-center">
        <div class="relative w-full sm:w-1/3">
            <select id="filter" class="w-full p-2 border-gray-300 border rounded-md shadow-sm text-gray-800 bg-white dark:border-gray-600 dark:bg-gray-600 dark:text-white focus:border-blue-500 focus:ring-blue-500 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50" onchange="filterPacks()">
                <option value="all" {{ request()->get('filter') == 'all' ? 'selected' : '' }}>Todos</option>
                <option value="personal_trainer" {{ request()->get('filter') == 'personal_trainer' ? 'selected' : '' }}>Acompanhados</option>
                <option value="individual" {{ request()->get('filter') == 'individual' ? 'selected' : '' }}>Livres</option>
            </select>
        </div>
    </div>

    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div id="packs-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($packs as $pack)
            <div class="pack-card dark:bg-gray-800 bg-gray-500 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105 flex flex-col justify-between cursor-pointer" data-name="{{ $pack->name }}" onclick="location.href='{{ url('packs/' . $pack->id) }}'">
                <div class="p-4 dark:bg-gray-800 bg-gray-500 flex-grow">
                    <h3 class="text-lg font-semibold mb-2 flex items-center">
                        @if($pack->trainingType->has_personal_trainer)
                            @if($pack->trainingType->max_capacity == 1)
                                <i class="fa-solid fa-user w-5 h-5 mr-1"></i>
                            @elseif($pack->trainingType->max_capacity == 2)
                                <i class="fa-solid fa-user-group w-5 h-5 mr-1"></i>
                            @elseif($pack->trainingType->max_capacity >= 3)
                                <i class="fa-solid fa-users w-5 h-5 mr-1"></i>
                            @endif
                        @else
                            <i class="fa-solid fa-person-running w-5 h-5 mr-1"></i>
                        @endif
                        {{ $pack->name }}
                    </h3>
                    <p class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                        <i class="fa-solid fa-hourglass-half w-4 h-4 mr-2"></i>
                        <span>Duração: {{ $pack->duration }} Dias</span>
                    </p>
                    <p class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                        <i class="fa-regular fa-calendar-check w-4 h-4 mr-2"></i>
                        <span>Treinos: {{ $pack->trainings_number }}</span>
                    </p>
                    <p class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                        <i class="fa-solid fa-user-tie w-4 h-4 mr-2"></i>
                        <span>{{ $pack->trainingType->has_personal_trainer ? 'Acompanhado' : 'Livre' }}</span>
                    </p>
                    <p class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                        <i class="fa-solid fa-coins w-4 h-4 mr-2"></i>
                        <span>Preço: {{ $pack->price }}€</span>
                    </p>
                </div>
                <div class="flex justify-end items-center p-4 mt-auto space-x-2" onclick="event.stopPropagation();">
                    @if(Auth::user()->hasRole('admin'))
                        @can('update', $pack)
                            <a href="{{ url('packs/' . $pack->id . '/edit') }}" class="bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400 mr-2">
                                <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                                Editar
                            </a>
                        @endcan
                        @can('delete', $pack)
                            <form id="delete-form-{{$pack->id}}" action="{{ url('packs/' . $pack->id) }}" method="POST" class="inline mr-2">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500" onclick="confirmDelete({{ $pack->id }})">
                                    <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                    Eliminar
                                </button>
                            </form>
                        @endcan
                    @else
                        @if(Auth::user()->membership && Auth::user()->membership->status->name === 'active')
                            <form action="{{ route('cart.addPack') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pack_id" value="{{ $pack->id }}">
                                <button type="submit" class="bg-blue-500 dark:bg-lime-500 text-white flex items-center px-2 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400 text-sm">
                                    <i class="fa-solid fa-cart-plus w-4 h-4 mr-2"></i>
                                    Adicionar
                                </button>
                            </form>
                        @else
                            <button type="button" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 flex items-center px-2 py-1 rounded-md cursor-not-allowed text-sm" title="Necessita de uma matrícula ativa">
                                <i class="fa-solid fa-lock w-4 h-4 mr-2"></i>
                                Adicionar
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $packs->appends(request()->query())->links() }}
    </div>
</div>

@if($showMembershipModal)
    <div id="membership-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
        <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
            <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Atenção</h2>
            <p class="mb-4 text-gray-700 dark:text-gray-200">Necessita de uma matrícula ativa para comprar packs de aulas.</p>
            <div class="flex justify-end">
                <button type="button" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500" onclick="closeMembershipModal()">Fechar</button>
            </div>
        </div>
    </div>
@endif

<div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelAction()">Cancelar</button>
            <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500" onclick="confirmAction()">Eliminar</button>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        packDeleted = id;
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function confirmAction() {
        document.getElementById(`delete-form-${packDeleted}`).submit();
    }

    function closeMembershipModal() {
        document.getElementById('membership-modal').classList.add('hidden');
    }

    function filterPacks() {
        const filterValue = document.getElementById('filter').value;
        const url = new URL(window.location.href);
        url.searchParams.set('filter', filterValue);
        window.location.href = url.href;
    }
</script>
