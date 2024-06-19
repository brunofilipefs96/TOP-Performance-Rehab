<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div>
                <h1 class="mb-6 dark:text-lime-400 text-gray-800 font-semibold">Pack {{$pack->id}}</h1>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-800 dark:text-white">Nome</label>
                <input type="text" value="{{$pack->name}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="duration" class="block text-gray-800 dark:text-white">Duração (dias)</label>
                <input class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{$pack->duration}}" disabled>
            </div>

            <div class="mb-4">
                <label for="trainings_number" class="block text-gray-800 dark:text-white">Número de Treinos</label>
                <input class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="text" value="{{$pack->trainings_number}}" disabled>
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
                <input class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{$pack->price}}" disabled>
            </div>

            <div class="flex justify-center mt-6">
                <a href="{{ route('packs.index') }}" class="inline-block bg-gray-500 mt-4 mb-5 py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>
