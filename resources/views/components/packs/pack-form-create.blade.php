<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <form method="POST" action="{{ url('packs') }}" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-center mb-5">
                    <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Adicionar Pacote</h1>
                    <hr class="border-t border-gray-300">
                </div>

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
                    <label for="trainings_number" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Número de Treinos</label>
                    <input type="number"
                           id="trainings_number"
                           name="trainings_number"
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
                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Personal Trainer</label>
                    <div class="flex items-center">
                        <input type="radio" id="personal_trainer_yes" name="has_personal_trainer" value="1" class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4  dark:bg-gray-600  dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500" {{ old('has_personal_trainer') == '1' ? 'checked' : '' }} required>
                        <label for="personal_trainer_yes" class="ml-2 dark:text-gray-200 text-gray-800">Sim</label>
                    </div>
                    <div class="flex items-center mt-2">
                        <input type="radio" id="personal_trainer_no" name="has_personal_trainer" value="0" class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4  dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400  focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500" {{ old('has_personal_trainer') == '0' ? 'checked' : '' }} required>
                        <label for="personal_trainer_no" class="ml-2 dark:text-gray-200 text-gray-800">Não</label>
                    </div>
                    @error('has_personal_trainer')
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

                <div class="flex justify-end gap-2">
                    <button type="submit" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Adicionar</button>
                    <button onclick="history.back()" class="mt-4 mb-5 bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-400">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
