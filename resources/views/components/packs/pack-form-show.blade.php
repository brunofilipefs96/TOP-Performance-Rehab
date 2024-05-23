<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div>
                <h1 class="mb-2">Pacote {{$pack->id}}</h1>
            </div>

            <div class="mb-4">
                <label for="name" class="block">Nome</label>
                <input type="text" value="{{$pack->name}}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="trainings_number" class="block">Número de Treinos</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm" type="text" value="{{$pack->trainings_number}}" disabled>
            </div>

            <div class="mb-4">
                <label for="has_personal_trainer" class="block">Personal Trainer</label>
                <div class="mt-1">
                    <label class="inline-flex items-center">
                        <input type="radio" name="has_personal_trainer" value="1" {{ $pack->has_personal_trainer ? 'checked' : '' }} disabled class="form-radio text-gray-600">
                        <span class="ml-2">Sim</span>
                    </label>
                    <label class="inline-flex items-center ml-4">
                        <input type="radio" name="has_personal_trainer" value="0" {{ !$pack->has_personal_trainer ? 'checked' : '' }} disabled class="form-radio text-gray-600">
                        <span class="ml-2">Não</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label for="price" class="block">Preço</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm" type="number" value="{{$pack->price}}" disabled>
            </div>

            <div class="flex justify-center mt-4">
                <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
            </div>
        </div>
    </div>
</div>
