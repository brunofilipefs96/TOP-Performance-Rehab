<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Tipos de Treino</h1>
    @can('create', App\Models\TrainingType::class)
        <a href="{{ url('training-types/create') }}" class="block mb-4">
            <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500  font-semibold dark:hover:bg-lime-400 dark:hover:text-gray-800">Adicionar tipo de treino</button>
        </a>
    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($training_types as $training_type)
            <div class="dark:bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none">
                <div class="flex justify-center">
                    @if($training_type->image && file_exists(public_path('storage/' . $training_type->image)))
                        <img src="{{ asset('storage/'. $training_type->image) }}" alt="{{ $training_type->name }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 dark:bg-gray-600 bg-gray-300 flex items-center justify-center ">
                            <span class="text-3xl">Sem imagem</span>
                        </div>
                    @endif
                </div>
                <div class="p-4 dark:bg-gray-800 bg-gray-500">
                    <h3 class="text-xl font-semibold mb-2">{{ $training_type->name }}</h3>
                    <div class="flex justify-end gap-2">
                        <a href="{{ url('training-types/' . $training_type->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-400 dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                        @can('update', $training_type)
                            <a href="{{ url('training-types/' . $training_type->id . '/edit') }}" class="bg-blue-600 text-white px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400">Editar</a>
                        @endcan
                        @can('delete', $training_type)
                            <form id="delete-form-{{$training_type->id}}" action="{{ url('training-types/' . $training_type->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500" id="delete-button" onclick="confirmarEliminacao({{ $training_type->id }})">Eliminar</button>
                            </form>

                            <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
                                    <p class="mb-4 dark:text-red-300 text-red-500">Não poderá reverter isso!</p>
                                    <div class="flex justify-end gap-4">
                                        <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                                        <button id="confirm-button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Eliminar</button>
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
</script>
