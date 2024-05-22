<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <form method="POST" action="{{ url('products') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <h1 class="text-xl font-bold text-gray-200">Adicionar Produto</h1>
                    <hr class="border-t border-gray-300">
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-200">Imagem</label>
                    <input type="file"
                           id="image"
                           name="image"
                           accept="image/*"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-200 placeholder-gray-500
                           @error('image') border-red-500 @enderror"
                           value="{{ old('image') }}"
                           aria-describedby="imageHelp">
                    @error('image')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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
                    <label for="quantity" class="block text-sm font-medium text-gray-200">Quantidade</label>
                    <input type="number"
                           id="quantity"
                           name="quantity"
                           autocomplete="quantity"
                           placeholder="Insira a quantidade"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('quantity') border-red-500 @enderror"
                           value="{{ old('quantity') }}"
                           required
                           aria-describedby="quantityHelp">
                    @error('quantity')
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

                <div class="mb-4">
                    <label for="details" class="block text-sm font-medium text-gray-200">Detalhes</label>
                    <textarea id="details"
                              name="details"
                              autocomplete="details"
                              placeholder="Escreva os detalhes"
                              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                              @error('details') border-red-500 @enderror"
                              required
                              aria-describedby="detailsHelp">{{ old('details') }}</textarea>
                    @error('details')
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