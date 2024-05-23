<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <form method="POST" action="{{ url('packs') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <h1 class="text-xl font-bold text-gray-200">Adicionar Pacote</h1>
                    <hr class="border-t border-gray-300">
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-200">Nome</label>
                    <input type="text"
                           id="name"
                           name="name"
                           autocomplete="name"
                           placeholder="Escreva o nome"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('name') border-red-500 @enderror"
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
                    <label for="trainings_number" class="block text-sm font-medium text-gray-200">Número de Treinos</label>
                    <input type="number"
                           id="trainings_number"
                           name="trainings_number"
                           autocomplete="trainings_number"
                           placeholder="Insira a quantidade de treinos"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('trainings_number') border-red-500 @enderror"
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
                    <label class="block text-sm font-medium text-gray-200">Personal Trainer</label>
                    <div class="flex items-center">
                        <input type="radio" id="personal_trainer_yes" name="has_personal_trainer" value="1" class="form-radio h-4 w-4 text-gray-800" {{ old('has_personal_trainer') == '1' ? 'checked' : '' }}>
                        <label for="personal_trainer_yes" class="ml-2 text-gray-200">Sim</label>
                    </div>
                    <div class="flex items-center mt-2">
                        <input type="radio" id="personal_trainer_no" name="has_personal_trainer" value="0" class="form-radio h-4 w-4 text-gray-800" {{ old('has_personal_trainer') == '0' ? 'checked' : '' }}>
                        <label for="personal_trainer_no" class="ml-2 text-gray-200">Não</label>
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
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('price') border-red-500 @enderror"
                           value="{{ old('price') }}"
                           required
                           aria-describedby="priceHelp">
                    @error('price')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="mt-4 mb-5 w-full bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700">Adicionar</button>
            </form>
        </div>
    </div>
</div>
