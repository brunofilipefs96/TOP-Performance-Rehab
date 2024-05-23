<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div class="flex justify-center mb-5">
                <h1 class="text-xl font-bold text-gray-200 dark:text-lime-400">Editar Pack</h1>
            </div>
            <div>
                <h1 class="mb-6 dark:text-lime-200 font-semibold">Pack {{$pack->id}}</h1>
            </div>
            <form method="POST" action="{{ url('packs/' . $pack->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-200">Nome</label>
                    <input type="text"
                           id="name"
                           name="name"
                           autocomplete="name"
                           placeholder="Insira o nome"
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('name') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ $pack->name }}"
                           required
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="trainings_number" class="block text-sm font-medium text-gray-200">Número de Treinos</label>
                    <input type="number"
                           id="trainings_number"
                           name="trainings_number"
                           autocomplete="trainings_number"
                           placeholder="Insira a quantidade de treinos"
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('trainings_number') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ $pack->trainings_number }}"
                           required
                           aria-describedby="trainings_numberHelp">
                    @error('trainings_number')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="has_personal_trainer" class="block text-sm font-medium text-gray-200">Personal Trainer</label>
                    <div class="mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="has_personal_trainer" value="1" {{ $pack->has_personal_trainer ? 'checked' : '' }} class="form-radio text-black dark:text-lime-400 h-4 w-4  dark:bg-gray-600  dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400">
                            <span class="ml-2 text-gray-200">Sim</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" name="has_personal_trainer" value="0" {{ !$pack->has_personal_trainer ? 'checked' : '' }} class="form-radio text-black dark:text-lime-400 h-4 w-4  dark:bg-gray-600  dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400">
                            <span class="ml-2 text-gray-200">Não</span>
                        </label>
                    </div>
                    @error('has_personal_trainer')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-200">Preço</label>
                    <input type="number"
                           id="price"
                           name="price"
                           autocomplete="price"
                           placeholder="Insira o preço"
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('price') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ $pack->price }}"
                           required
                           aria-describedby="priceHelp">
                    @error('price')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <button type="submit" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900">Atualizar</button>
                    <button onclick="history.back()" class="bg-gray-500 mt-4 mb-5 py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 dark:bg-gray-500 dark:hover:bg-gray-400">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
