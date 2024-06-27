<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('packs.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center">
                <h1 class="mb-8 mt-4 dark:text-lime-400 text-gray-800 font-semibold">{{ $pack->name }}</h1>
            </div>

            <div class="mb-4">
                <label for="duration" class="block text-gray-800 dark:text-white">Duração (dias)</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $pack->duration }}" disabled>
            </div>

            <div class="mb-4">
                <label for="trainings_number" class="block text-gray-800 dark:text-white">Número de Treinos</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="text" value="{{ $pack->trainings_number }}" disabled>
            </div>

            <div class="mb-4">
                <label for="has_personal_trainer" class="block text-gray-800 dark:text-white">Personal Trainer</label>
                <div class="mt-1">
                    <label class="inline-flex items-center">
                        <input type="radio" name="has_personal_trainer" value="1" {{ $pack->has_personal_trainer ? 'checked' : '' }} disabled class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500">
                        <span class="ml-2 dark:text-gray-200 text-gray-800">Sim</span>
                    </label>
                    <label class="inline-flex items-center ml-4">
                        <input type="radio" name="has_personal_trainer" value="0" {{ !$pack->has_personal_trainer ? 'checked' : '' }} disabled class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500">
                        <span class="ml-2 dark:text-gray-200 text-gray-800">Não</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-800 dark:text-white">Preço</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $pack->price }}" disabled>
            </div>

            @if(Auth::user()->hasRole('admin'))
                <div class="flex justify-end items-center mb-4 mt-10">
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
                            <button type="button" class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500" id="delete-button" onclick="confirmDelete({{ $pack->id }})">
                                <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            @else
                <div class="flex justify-end items-center mb-4 mt-10">
                    @if(auth()->user()->membership && auth()->user()->membership->status->name === 'active')
                        <form action="{{ route('cart.addPack') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pack_id" value="{{ $pack->id }}">
                            <button type="submit" class="bg-blue-500 dark:bg-lime-500 text-white flex items-center px-2 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400 text-sm">
                                <i class="fa-solid fa-cart-plus w-4 h-4 mr-2"></i>
                                Adicionar
                            </button>
                        </form>
                    @else
                        <button type="button" class="bg-gray-500 dark:bg-gray-700 text-white flex items-center px-2 py-1 rounded-md text-sm cursor-not-allowed" disabled>
                            <i class="fa-solid fa-cart-plus w-4 h-4 mr-2"></i>
                            Adicionar
                        </button>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>

<div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelAction()">Cancelar</button>
            <button type="button" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500" onclick="confirmAction()">Confirmar</button>
        </div>
    </div>
</div>

@if($showMembershipModal)
    <div id="membership-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
        <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
            <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Atenção</h2>
            <p class="mb-4 text-gray-700 dark:text-gray-200">Necessita de uma matrícula ativa para adquirir packs.</p>
            <div class="flex justify-end">
                <button type="button" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500" onclick="closeMembershipModal()">Fechar</button>
            </div>
        </div>
    </div>

    <script>
        function closeMembershipModal() {
            document.getElementById('membership-modal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('membership-modal').classList.remove('hidden');
        });
    </script>
@endif

<script>
    let packDeleted = 0;

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
</script>

