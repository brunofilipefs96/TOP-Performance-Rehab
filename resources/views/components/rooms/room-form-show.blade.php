<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <div>
                <h1 class="mb-2 dark:text-lime-400 font-semibold text-gray-800">Sala {{$room->id}}</h1>
            </div>

            <div class="mb-4">
                <label for="name" class="block dark:text-white text-gray-800">Nome</label>
                <input type="text" value="{{$room->name}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="capacity" class="block dark:text-white text-gray-800">Capacidade</label>
                <input class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{$room->capacity}}" disabled>
            </div>

            <div class="flex justify-center mt-6">
                <a href="{{ route('rooms.index') }}" class="inline-block bg-gray-500 mt-4 mb-5 py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>
