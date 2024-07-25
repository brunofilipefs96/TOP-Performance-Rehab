<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('products.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Adicionar Produto</h1>
            </div>
            <form method="POST" action="{{ url('products') }}" enctype="multipart/form-data" onsubmit="disableConfirmButton(this)">
                @csrf
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Imagem</label>
                    <input type="file"
                           id="image"
                           name="image"
                           accept="image/*"
                           class="mt-1 block w-full p-2 bg-gray-100 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:text-gray-200 placeholder-gray-500
                           @error('image') border-red-500 @enderror dark:bg-gray-600"
                           value="{{ old('image') }}"
                           aria-describedby="imageHelp">
                    @error('image')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome</label>
                    <input type="text"
                           id="name"
                           name="name"
                           autocomplete="name"
                           placeholder="Escreva o nome"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50
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
                    <label for="quantity" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Quantidade</label>
                    <input type="number"
                           id="quantity"
                           name="quantity"
                           autocomplete="quantity"
                           placeholder="Insira a quantidade"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('quantity') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ old('quantity') }}"
                           min="0"
                           required
                           aria-describedby="quantityHelp">
                    @error('quantity')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Preço</label>
                    <input type="number"
                           id="price"
                           name="price"
                           autocomplete="price"
                           placeholder="Insira o preço"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('price') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ old('price') }}"
                           min="0"
                           step="0.01"
                           required
                           aria-describedby="priceHelp">
                    @error('price')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="details" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Detalhes</label>
                    <textarea id="details"
                              name="details"
                              autocomplete="details"
                              placeholder="Escreva os detalhes"
                              class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                              @error('details') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                              required
                              aria-describedby="detailsHelp">{{ old('details') }}</textarea>
                    @error('details')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 mt-10">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>
