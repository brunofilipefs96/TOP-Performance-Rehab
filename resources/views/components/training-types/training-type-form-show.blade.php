<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('training-types.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center">
                <h1 class="mb-8 mt-4 dark:text-lime-400 text-gray-800 font-semibold">{{ $training_type->name }}</h1>
            </div>

            @if($training_type->image && file_exists(public_path('storage/' . $training_type->image)))
                <div class="mb-4 select-none">
                    <label for="image" class="block text-gray-800 dark:text-white">Imagem</label>
                    <img src="{{ asset('storage/' . $training_type->image) }}" alt="Imagem do Tipo de Treino" class="mt-1 block w-full h-auto border border-gray-300 rounded-md shadow-sm">
                </div>
            @else
                <div class="mb-4">
                    <label for="image" class="block text-gray-800 dark:text-white">Imagem</label>
                    <div class="mt-1 block w-full h-40 bg-gray-100 dark:bg-gray-600 flex items-center justify-center text-white rounded-md shadow-sm">
                        <span class="text-xl dark:text-white text-gray-800">Sem imagem</span>
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <label for="name" class="block text-gray-800 dark:text-white">Nome</label>
                <input type="text" name="name" id="name" value="{{ $training_type->name }}" disabled class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="has_personal_trainer" class="block text-gray-800 dark:text-white">Tem Personal Trainer?</label>
                <input type="text" name="has_personal_trainer" id="has_personal_trainer" value="{{ $training_type->has_personal_trainer ? 'Sim' : 'Não' }}" disabled class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="max_capacity" class="block text-gray-800 dark:text-white">Capacidade Máxima</label>
                <input type="text" name="max_capacity" id="max_capacity" value="{{ $training_type->max_capacity ?? 'Ilimitada' }}" disabled class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="is_electrostimulation" class="block text-gray-800 dark:text-white">É de Eletroestimulação?</label>
                <input type="text" name="is_electrostimulation" id="is_electrostimulation" value="{{ $training_type->is_electrostimulation ? 'Sim' : 'Não' }}" disabled class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="flex justify-end items-center p-4 mt-auto space-x-2">
                @can('update', $training_type)
                    <a href="{{ url('training-types/' . $training_type->id . '/edit') }}" class="bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400 text-sm">
                        <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                        Editar
                    </a>
                @endcan
                @can('delete', $training_type)
                    <form id="delete-form-{{$training_type->id}}" action="{{ url('training-types/' . $training_type->id) }}" method="POST" class="inline text-sm" onsubmit="disableConfirmButton(this)">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500" id="delete-button" onclick="confirmarEliminacao({{ $training_type->id }})">
                            <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                            Eliminar
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>

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

<script>
    let trainingTypeDeleted = 0;

    function confirmarEliminacao(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        trainingTypeDeleted = id;
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById(`delete-form-${trainingTypeDeleted}`).submit();
    });

    function applyFilter() {
        var filter = document.getElementById('filter').value;
        window.location.href = '{{ url("training-types") }}?filter=' + filter;
    }
</script>
