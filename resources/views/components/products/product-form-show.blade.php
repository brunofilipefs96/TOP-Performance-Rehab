<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div>
                <h1 class="mb-2">Produto {{$product->id}}</h1>
            </div>

            @if($product->image)
                <div class="mb-4">
                    <label for="image" class="block">Imagem</label>
                    <img src="{{ $product->image }}" alt="Imagem do Produto" class="mt-1 block w-full h-auto border border-gray-300 rounded-md shadow-sm">
                </div>
            @endif

            <div class="mb-4">
                <label for="name" class="block">Nome</label>
                <input type="text" value="{{$product->name}}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="quantity" class="block">Quantidade</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm" type="number" value="{{$product->quantity}}" disabled>
            </div>

            <div class="mb-4">
                <label for="price" class="block">Preço</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm" type="number" value="{{$product->price}}" disabled>
            </div>

            <div class="mb-4">
                <label for="details" class="block">Detalhes</label>
                <textarea class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm" type="text" disabled>{{$product->details}}</textarea>
            </div>
        </div>
    </div>
</div>
