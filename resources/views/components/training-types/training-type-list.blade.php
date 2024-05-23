<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 text-white">Tipos de Treino</h1>
    @can('create', App\Models\TrainingType::class)
        <a href="{{ url('training-types/create') }}" class="block mb-4">
            <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-700 dark:bg-lime-500  font-semibold dark:hover:bg-lime-400 dark:hover:text-gray-800">Adicionar tipo de treino</button>
        </a>
    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($training_types as $training_type)
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none">
                <div class="flex justify-center">
                    @if($training_type->image && file_exists(public_path($training_type->image)))
                        <img src="{{ asset($training_type->image) }}" alt="{{ $training_type->name }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-600 flex items-center justify-center">
                            <span class="text-3xl">Sem imagem</span>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $training_type->name }}</h3>
                    <div class="flex justify-end gap-2">
                        <a href="{{ url('training-types/' . $training_type->id) }}" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-700 dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                        @can('update', $training_type)
                            <a href="{{ url('training-types/' . $training_type->id . '/edit') }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-700 dark:bg-gray-500 dark:hover:bg-gray-400">Editar</a>
                        @endcan
                        @can('delete', $training_type)
                            <form id="delete-form-training" action="{{ url('training-types/' . $training_type->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500" id="delete-button-training">Eliminar</button>
                            </form>

                            <div id="confirmation-modal-training" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                <div class="bg-white p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                    <h2 class="text-xl font-bold mb-4">Pretende eliminar?</h2>
                                    <p class="mb-4 dark:text-red-300">Não poderá reverter isso!</p>
                                    <div class="flex justify-end gap-4">
                                        <button id="cancel-button-training" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                                        <button id="confirm-button-training" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Eliminar</button>
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
        {{ $training_types->links() }}
    </div>
</div>

<script>
    document.getElementById('delete-button-training').addEventListener('click', function() {
        document.getElementById('confirmation-modal-training').classList.remove('hidden');
    });

    document.getElementById('cancel-button-training').addEventListener('click', function() {
        document.getElementById('confirmation-modal-training').classList.add('hidden');
    });

    document.getElementById('confirm-button-training').addEventListener('click', function() {
        document.getElementById('delete-form-training').submit();
    });
</script>
