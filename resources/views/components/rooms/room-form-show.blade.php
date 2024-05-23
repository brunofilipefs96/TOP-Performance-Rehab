<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div>
                <h1 class="mb-2 dark:text-lime-400 font-semibold">Sala {{$room->id}}</h1>
            </div>

            <div class="mb-4">
                <label for="name" class="block">Nome</label>
                <input type="text" value="{{$room->name}}" disabled class="mt-1 block w-full p-2 border border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="capacity" class="block">Capacidade</label>
                <input class="mt-1 block w-full p-2 border border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{$room->capacity}}" disabled>
            </div>

            <div class="flex justify-center mt-6">
                <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Voltar</button>
            </div>
        </div>
    </div>
</div>
