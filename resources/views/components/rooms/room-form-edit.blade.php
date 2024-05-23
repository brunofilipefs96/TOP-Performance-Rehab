<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div class="flex justify-center mb-5">
                <h1 class="text-xl font-bold text-gray-200 dark:text-lime-400">Editar Sala</h1>
            </div>
            <div>
                <h1 class="mb-6 dark:text-lime-200 font-semibold">Sala {{$room->id}}</h1>
            </div>
            <form method="POST" action="{{ url('rooms/' . $room->id) }}" enctype="multipart/form-data">
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
                           value="{{ $room->name }}"
                           required
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="capacity" class="block text-sm font-medium text-gray-200">Capacidade</label>
                    <input type="number"
                           id="capacity"
                           name="capacity"
                           autocomplete="capacity"
                           placeholder="Insira a capacidade"
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('capacity') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ $room->capacity }}"
                           required
                           aria-describedby="capacityHelp">
                    @error('capacity')
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
