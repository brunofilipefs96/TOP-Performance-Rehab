<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div>
                <h1 class="mb-2 dark:text-lime-400 font-semibold">{{$training_type->name}}</h1>
            </div>

            @if($training_type->image && file_exists(public_path($training_type->image)))
                <div class="mb-4 select-none">
                    <label for="image" class="block">Imagem</label>
                    <img src="{{ asset($training_type->image) }}" alt="Imagem do Tipo de Treino" class="mt-1 block w-full h-auto border border-gray-300 rounded-md shadow-sm">
                </div>
            @else
                <div class="mb-4">
                    <label for="image" class="block">Imagem</label>
                    <div class="mt-1 block w-full h-40 bg-gray-600 flex items-center justify-center text-white rounded-md shadow-sm">
                        <span class="text-xl">Sem imagem</span>
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <label for="name" class="block">Nome</label>
                <input type="text" name="name" id="name" value="{{$training_type->name}}" disabled class="mt-1 block w-full p-2 border border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="flex justify-center mt-6">
                <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Voltar</button>
            </div>
        </div>
    </div>
</div>
