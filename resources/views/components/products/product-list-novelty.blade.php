
<div class="container mx-auto ">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Novidades para si!</h1>

    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($products as $product)
            <div class="product-card dark:bg-gray-800 bg-gray-500 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105 flex flex-col justify-between" data-name="{{ $product->name }}">
                <a href="{{ url('products/' . $product->id) }}" class="flex-grow">
                    <div class="flex justify-center">
                        @if($product->image && file_exists(public_path('storage/' . $product->image)))
                            <img src="{{ asset('storage/'. $product->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover">
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
                    </div>
                </a>
                <div class="flex justify-end items-center p-4 mt-auto space-x-2">
                    @if(!Auth::user()->hasRole('admin'))
                        <form id="add-cart-form-{{$product->id}}" action="{{ url('cart/add') }}" method="POST" class="inline text-sm">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400 flex items-center">
                                <i class="fa-solid fa-cart-plus w-4 h-4 inline-block fill-current text-white mr-2"></i>
                                Adicionar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
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
