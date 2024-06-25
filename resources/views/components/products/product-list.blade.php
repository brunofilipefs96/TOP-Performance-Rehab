<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Produtos</h1>
    @can('create', App\Models\Product::class)
        <div class="mb-10 flex justify-between items-center">
            <a href="{{ url('products/create') }}">
                <button type="button"
                        class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm">
                    <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
                    Adicionar Produto
                </button>
            </a>

            <div class="relative w-1/3">
                <i class="fa-solid fa-magnifying-glass absolute w-5 h-5 left-3 top-1/2 transform -translate-y-1/2 text-black dark:text-white"></i>
                <input type="text" id="search" placeholder="Pesquisar produtos..."
                       class="w-full p-2 pl-10 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-light-gray dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50">
            </div>
        </div>
    @endcan
    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <div
                class="product-card dark:bg-gray-800 bg-gray-500 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105 flex flex-col justify-between"
                data-name="{{ $product->name }}">
                <a href="{{ url('products/' . $product->id) }}" class="flex-grow">
                    <div class="flex justify-center">
                        @if($product->image && file_exists(public_path('storage/' . $product->image)))
                            <img src="{{ asset('storage/'. $product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-32 object-cover">
                        @else
                            <div class="w-full h-32 dark:bg-gray-600 bg-gray-300 flex items-center justify-center">
                                <span class="text-2xl">Sem imagem</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 dark:bg-gray-800 bg-gray-500 flex-grow">
                        <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                        <div class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                            <i class="fa-solid fa-coins w-4 h-4 mr-2"></i>
                            <span>{{ $product->price }} €</span>
                        </div>
                        @can('update', $product)
                            @if($product->quantity <= 5)
                                <div class="text-red-400 mb-2 flex items-center text-md">
                                    <i class="fa-solid fa-box-open w-4 h-4 mr-2 text-red-400"></i>
                                    <span>{{ $product->quantity }} Unidades</span>
                                </div>
                            @else
                                <div class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                                    <i class="fa-solid fa-box-open w-4 h-4 mr-2"></i>
                                    <span>{{ $product->quantity }} Unidades</span>
                                </div>
                            @endif
                        @endcan
                    </div>
                </a>
                <div class="flex justify-end items-center p-4 mt-auto space-x-2">
                    @can('update', $product)
                        <a href="{{ url('products/' . $product->id . '/edit') }}"
                           class="bg-blue-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400 text-sm">
                            <i class="fa-solid fa-pen-to-square w-4 h-4 mr-2"></i>
                            Editar
                        </a>
                    @endcan
                    @can('delete', $product)
                        <form id="delete-form-{{$product->id}}" action="{{ url('products/' . $product->id) }}"
                              method="POST" class="inline text-sm">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="bg-red-600 text-white flex items-center px-2 py-1 rounded-md hover:bg-red-500"
                                    onclick="confirmDelete({{ $product->id }})">
                                <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                                Eliminar
                            </button>
                        </form>
                    @endcan
                    @if(!Auth::user()->hasRole('admin'))
                        <form id="add-cart-form-{{$product->id}}" action="{{ route('cart.addProduct') }}" method="POST"
                              class="inline text-sm">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit"
                                    class="dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400 flex items-center">
                                <i class="fa-solid fa-cart-plus w-4 h-4 inline-block fill-current text-white mr-2"></i>
                                Adicionar
                            </button>
                        </form>
                    @endif
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

    document.addEventListener('DOMContentLoaded', function () {
        const cancelButton = document.getElementById('cancel-button');
        const confirmButton = document.getElementById('confirm-button');
        const searchInput = document.getElementById('search');

        if (cancelButton) {
            cancelButton.addEventListener('click', function () {
                document.getElementById('confirmation-modal').classList.add('hidden');
            });
        }

        if (confirmButton) {
            confirmButton.addEventListener('click', function () {
                document.getElementById(`delete-form-${productDeleted}`).submit();
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterProducts);
        }

        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase();
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
    });
</script>
