<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('training-types.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Editar Tipo de Treino</h1>
            </div>
            <form method="POST" id="update-form" action="{{ url('training-types/' . $training_type->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if($training_type->image && file_exists(public_path('storage/' . $training_type->image)))
                    <div class="mb-4 select-none">
                        <label for="image" class="block">Imagem atual</label>
                        <img src="{{ asset('storage/' . $training_type->image) }}" alt="Imagem do Tipo de Treino" class="mt-1 block w-full h-auto border border-gray-300 rounded-md shadow-sm">
                    </div>
                @else
                    <div class="mb-4">
                        <label for="image" class="block text-gray-800 dark:text-white">Imagem atual</label>
                        <div class="mt-1 block w-full h-40 bg-gray-100 dark:bg-gray-600 flex items-center justify-center text-white rounded-md shadow-sm">
                            <span class="text-xl dark:text-white text-gray-800">Sem imagem</span>
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Escolha uma imagem</label>
                    <input type="file"
                           id="image"
                           name="image"
                           autocomplete="image"
                           placeholder="Escolha a imagem"
                           class="mt-1 block w-full p-2 bg-gray-100 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('image') border-red-500 @enderror dark:bg-gray-600 dark:text-white"
                           value="{{ $training_type->image }}"
                           aria-describedby="imageHelp">
                    @error('image')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome</label>
                    <input type="text"
                           id="name"
                           name="name"
                           autocomplete="name"
                           placeholder="Insira o nome"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('name') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ $training_type->name }}"
                           required
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="has_personal_trainer" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Tem Personal Trainer?</label>
                    <select id="has_personal_trainer" name="has_personal_trainer" class="mt-1 block w-full p-2 bg-gray-100 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white" onchange="toggleMaxCapacity()">
                        <option value="1" {{ $training_type->has_personal_trainer ? 'selected' : '' }}>Sim</option>
                        <option value="0" {{ !$training_type->has_personal_trainer ? 'selected' : '' }}>Não</option>
                    </select>
                    @error('has_personal_trainer')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4" id="max_capacity_field" style="{{ $training_type->has_personal_trainer ? '' : 'display: none;' }}">
                    <label for="max_capacity" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Capacidade Máxima</label>
                    <select id="max_capacity" name="max_capacity" class="mt-1 block w-full p-2 bg-gray-100 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white">
                        <option value="" {{ old('max_capacity', $training_type->max_capacity) === null ? 'selected' : '' }}>Definir no próprio treino</option>
                        <option value="1" {{ old('max_capacity', $training_type->max_capacity) == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ old('max_capacity', $training_type->max_capacity) == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ old('max_capacity', $training_type->max_capacity) == 3 ? 'selected' : '' }}>3</option>
                    </select>
                    @error('max_capacity')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 mt-10">
                    <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900 text-sm" onclick="confirmarAtualizacao()">Atualizar</button>
                </div>
            </form>
            <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende atualizar?</h2>
                    <p class="mb-4 dark:text-lime-200 text-gray-800">Poderá reverter isso!</p>
                    <div class="flex justify-end gap-4">
                        <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                        <button id="confirm-button" class="bg-blue-500 hover:bg-blue-400 dark:bg-lime-500 text-white px-4 py-2 rounded-md dark:hover:bg-lime-400">Atualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmarAtualizacao() {
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById('update-form').submit();
    });

    function toggleMaxCapacity() {
        var hasPersonalTrainer = document.getElementById('has_personal_trainer').value;
        var maxCapacityField = document.getElementById('max_capacity_field');
        var maxCapacityInput = document.getElementById('max_capacity');

        if (hasPersonalTrainer == "1") {
            maxCapacityField.style.display = 'block';
            if (!maxCapacityInput.value) {
                maxCapacityInput.value = 1;
            }
        } else {
            maxCapacityField.style.display = 'none';
            maxCapacityInput.value = null;
        }
    }
</script>
