<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Produtos</h1>
    @can('create', App\Models\Product::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ url('products/create') }}">
                <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center">
                    <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
                    Adicionar Produto
                </button>
            </a>

            <div class="relative w-1/3">
                <i class="fa-solid fa-magnifying-glass absolute w-5 h-5 left-3 top-1/2 transform -translate-y-1/2 text-black dark:text-white"></i>
                <input type="text" id="search" placeholder="Pesquisar produtos..." class="w-full p-2 pl-10 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
            </div>
        </div>
    @endcan
    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <div class="product-card dark:bg-gray-800 bg-gray-500 rounded-lg overflow-hidden shadow-md text-white select-none" data-name="{{ $product->name }}">
                <a href="{{ url('products/' . $product->id) }}">
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
                        <div class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-lg">
                            <i class="fa-solid fa-coins w-5 h-5 mr-2"></i>
                            <span>{{ $product->price }} €</span>
                        </div>
                        @can('update', $product)
                            @if($product->quantity <= 5)
                                <div class="text-red-400 mb-2 flex items-center text-lg">
                                    <i class="fa-solid fa-box-open w-5 h-5 mr-2 text-red-400"></i>
                                    <span>{{ $product->quantity }} Unidades</span>
                                </div>
                            @else
                                <div class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-lg">
                                    <i class="fa-solid fa-box-open w-5 h-5 mr-2"></i>
                                    <span>{{ $product->quantity }} Unidades</span>
                                </div>
                            @endif
                        @endcan
                    </div>
                </a>
                <div class="flex flex-wrap justify-end items-center gap-2 p-4">
                    <form id="add-cart-form-{{$product->id}}" action="{{ url('cart/add') }}" method="POST" class="inline">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="dark:bg-lime-400 bg-blue-500 px-3 py-1 rounded-md" id="add-cart-button">
                            <i class="fa-solid fa-cart-plus w-5 h-5 inline-block fill-current text-white"></i>
                            @if(!Auth::user()->hasRole('admin'))
                                Adicionar ao Carrinho
                            @endif
                        </button>
                    </form>
                    @can('update', $product)
                        <a href="{{ url('products/' . $product->id . '/edit') }}" class="bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400">
                            <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                            Editar
                        </a>
                    @endcan
                    @can('delete', $product)
                        <form id="delete-form-{{$product->id}}" action="{{ url('products/' . $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500" id="delete-button" onclick="confirmDelete({{ $product->id }})">
                                <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                Eliminar
                            </button>
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
