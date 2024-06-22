<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('products.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center">
                <h1 class="mb-8 mt-4 dark:text-lime-400 text-gray-800 font-semibold">{{ $product->name }}</h1>
            </div>

            @if($product->image && file_exists(public_path('storage/' . $product->image)))
                <div class="mb-4 select-none">
                    <label for="image" class="block">Imagem</label>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Imagem do Produto" class="mt-1 block w-full h-auto border border-gray-300 rounded-md shadow-sm">
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
                <label for="quantity" class="block text-gray-800 dark:text-white">Quantidade</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $product->quantity }}" disabled>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-800 dark:text-white">Preço</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $product->price }}" disabled>
            </div>

            <div class="mb-4">
                <label for="details" class="block text-gray-800 dark:text-white">Detalhes</label>
                <textarea class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="text" disabled>{{ $product->details }}</textarea>
            </div>

            @if(!Auth::user()->hasRole('admin'))
                <div class="flex justify-end items-center mb-4 mt-10">
                    <form id="add-cart-form-{{$product->id}}" action="{{ route('cart.addProduct') }}" method="POST" class="inline">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="dark:bg-lime-500 bg-blue-500 text-white flex items-center px-4 py-2 rounded-md hover:bg-blue-400 dark:hover:bg-lime-400 mr-2">
                            <i class="fa-solid fa-cart-plus w-5 h-5 mr-2"></i>
                            Adicionar
                        </button>
                    </form>
                </div>
            @endif

            @can('update', $product)
                <div class="flex justify-end items-center mb-4 mt-10">
                    <a href="{{ url('products/' . $product->id . '/edit') }}" class="bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400 mr-2">
                        <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                        Editar
                    </a>
                    @can('delete', $product)
                        <form id="delete-form-{{$product->id}}" action="{{ url('products/' . $product->id) }}" method="POST" class="inline mr-2">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500" id="delete-button" onclick="confirmDelete({{ $product->id }})">
                                <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            @endcan

        </div>
    </div>
</div>

<div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelAction()">Cancelar</button>
            <form id="confirmation-form" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500">Confirmar</button>
            </form>
        </div>
    </div>
</div>

<script>
    let productDeleted = 0;

    function confirmDelete(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        productDeleted = id;
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById(`delete-form-${productDeleted}`).submit();
    });
</script>
