<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div>
                <h1 class="mb-2">Sala {{$room->id}}</h1>
            </div>

            <div class="mb-4">
                <label for="name" class="block">Nome</label>
                <input type="text" value="{{$room->name}}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="capacity" class="block">Capacidade</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm" type="number" value="{{$room->capacity}}" disabled>
            </div>

            <div class="flex justify-center mt-4">
                <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
            </div>
        </div>
    </div>
</div>
