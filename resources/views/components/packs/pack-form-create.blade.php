<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('packs.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Adicionar Pack</h1>
            </div>
            <form method="POST" action="{{ url('packs') }}" enctype="multipart/form-data" onsubmit="disableConfirmButton(this)">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome</label>
                    <input type="text"
                           id="name"
                           name="name"
                           autocomplete="name"
                           placeholder="Escreva o nome"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('name') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ old('name') }}"
                           required
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Duração (dias)</label>
                    <input type="number"
                           id="duration"
                           name="duration"
                           min="1"
                           autocomplete="duration"
                           placeholder="Insira a duração em dias"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('duration') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ old('duration') }}"
                           required
                           aria-describedby="durationHelp">
                    @error('duration')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="trainings_number" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Número de Treinos</label>
                    <input type="number"
                           id="trainings_number"
                           name="trainings_number"
                           min="1"
                           autocomplete="trainings_number"
                           placeholder="Insira a quantidade de treinos"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('trainings_number') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ old('trainings_number') }}"
                           required
                           aria-describedby="trainingsNumberHelp">
                    @error('trainings_number')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="training_type_id" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Tipo de Treino</label>
                    <select id="training_type_id" name="training_type_id" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50" required>
                        @foreach($training_types as $training_type)
                            <option value="{{ $training_type->id }}" {{ old('training_type_id') == $training_type->id ? 'selected' : '' }}>{{ $training_type->name }}</option>
                        @endforeach
                    </select>
                    @error('training_type_id')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Preço</label>
                    <input type="number"
                           id="price"
                           name="price"
                           step="0.01"
                           min="0"
                           autocomplete="price"
                           placeholder="Insira o preço"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('price') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ old('price') }}"
                           required
                           aria-describedby="priceHelp">
                    @error('price')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 mt-10">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>
