<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center ">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div>
                <h1 class="mb-6 dark:text-lime-400 text-gray-800 font-semibold">Produto {{$product->id}}</h1>
            </div>

            @if($product->image && file_exists(public_path($product->image)))
                <div class="mb-4 select-none">
                    <label for="image" class="block">Imagem</label>
                    <img src="{{ asset($product->image) }}" alt="Imagem do Produto" class="mt-1 block w-full h-auto border border-gray-300 rounded-md shadow-sm">
                </div>
            @else
                <div class="mb-4">
                    <label for="image" class="block text-gray-800 dark:text-white">Imagem</label>
                    <div class="mt-1 block w-full h-40 bg-gray-100 dark:bg-gray-600 flex items-center justify-center text-white rounded-md shadow-sm">
                        <span class="text-xl dark:text-white text-gray-800">Sem imagem</span>
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <label for="name" class="block text-gray-800">Nome</label>
                <input type="text" value="{{$product->name}}" disabled class="mt-1 block w-full p-2 text-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-gray-800">Quantidade</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{$product->quantity}}" disabled>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-800">Preço</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{$product->price}}" disabled>
            </div>

            <div class="mb-4">
                <label for="details" class="block text-gray-800">Detalhes</label>
                <textarea class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="text" disabled>{{$product->details}}</textarea>
            </div>
            <div class="flex justify-center mt-6">
                <button onclick="history.back()" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Voltar</button>
            </div>
        </div>
    </div>
</div>
