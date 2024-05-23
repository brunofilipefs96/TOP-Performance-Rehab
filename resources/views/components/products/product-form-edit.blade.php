<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div class="mb-3 flex justify-center mb-5">
                <h1 class="text-xl font-bold text-gray-200 dark:text-lime-400">Editar Produto</h1>
            </div>
            <div>
                <h1 class="mb-6 dark:text-lime-200 font-semibold">Produto {{$product->id}}</h1>
            </div>
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-200">Imagem</label>
                    <input type="file"
                           id="image"
                           name="image"
                           accept="image/*"
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-200 placeholder-gray-500
                           @error('image') border-red-500 @enderror dark:bg-gray-600 dark:text-white"
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
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('name') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ $product->name }}"
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
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('quantity') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ $product->quantity }}"
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
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('price') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ $product->price }}"
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
                              class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                              @error('details') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                              required
                              aria-describedby="detailsHelp">{{ $product->details }}</textarea>
                    @error('details')
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
