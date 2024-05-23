<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <form method="POST" action="{{ url('rooms') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <h1 class="text-xl font-bold text-gray-200">Adicionar Sala</h1>
                    <hr class="border-t border-gray-300">
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-200">Nome</label>
                    <input type="text"
                           id="name"
                           name="name"
                           autocomplete="name"
                           placeholder="Insira o nome"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('name') border-red-500 @enderror"
                           value="{{ old('name') }}"
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
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('capacity') border-red-500 @enderror"
                           value="{{ old('capacity') }}"
                           required
                           aria-describedby="nameHelp">
                    @error('capacity')
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
