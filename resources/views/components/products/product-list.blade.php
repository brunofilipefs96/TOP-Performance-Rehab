
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Produtos</h1>
    @can('create', App\Models\Product::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ url('products/create') }}">
                <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold">Adicionar Produto</button>
            </a>

            <input type="text" id="search" placeholder="Pesquisar produtos..." class="w-1/3 p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
        </div>
        <hr class="mb-10 border-gray-400 dark:border-gray-300">
    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <div class="product-card dark:bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none" data-name="{{ $product->name }}">
                <div class="flex justify-center">
                    @if($product->image && file_exists(public_path('storage/' . $product->image)))
                        <img src="{{ asset('storage/'. $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 dark:bg-gray-600 bg-gray-300 flex items-center justify-center ">
                            <span class="text-3xl">Sem imagem</span>
                        </div>
                    @endif
                </div>
                <div class="p-4 dark:bg-gray-800 bg-gray-500">
                    <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-400 font-semibold mb-2">Preço: {{ $product->price }}€</p>
                    <div class="flex justify-end items-center mt-4 gap-2">
                        <form id="add-cart-form-{{$product->id}}" action="{{ url('cart/add') }}" method="POST" class="inline">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="dark:bg-lime-400 bg-blue-500 px-3 py-1 mr-10 rounded-md" id="add-cart-button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-5 h-5 inline-block fill-current text-white"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96zM252 160c0 11 9 20 20 20h44v44c0 11 9 20 20 20s20-9 20-20V180h44c11 0 20-9 20-20s-9-20-20-20H356V96c0-11-9-20-20-20s-20 9-20 20v44H272c-11 0-20 9-20 20z"/></svg>
                            </button>

                        </form>
                        <a href="{{ url('products/' . $product->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-400 dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                        @can('update', $product)
                            <a href="{{ url('products/' . $product->id . '/edit') }}" class="bg-blue-600 text-white px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400">Editar</a>
                        @endcan
                        @can('delete', $product)
                            <form id="delete-form-{{$product->id}}" action="{{ url('products/' . $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500" id="delete-button" onclick="confirmDelete({{ $product->id }})">Eliminar</button>
                            </form>

                            <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
                                    <p class="mb-4 dark:text-red-300 text-red-500">Não poderá reverter isso!</p>
                                    <div class="flex justify-end gap-4">
                                        <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                                        <button id="confirm-button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Eliminar</button>
                                    </div>
                                </div>
                            </div>

                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $products->links() }}
    </div>
</div>

<script>
    let productDeleted = 0;

    function confirmDelete(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        productDeleted = id;
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById(`delete-form-${productDeleted}`).submit();
    });

    function filterProducts() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            if (name.includes(searchTerm)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    document.getElementById('search').addEventListener('input', filterProducts);
</script>

