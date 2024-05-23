<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 text-white">Lista de Produtos</h1>
    @can('create', App\Models\Product::class)
        <div class="mb-5">
            <a href="{{ url('products/create') }}">
                <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-700 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold">Adicionar Produto</button>
            </a>
        </div>

    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-2xl text-white select-none">
                <div class="flex justify-center">
                    @if($product->image && file_exists(public_path($product->image)))
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-600 flex items-center justify-center ">
                            <span class="text-3xl">Sem imagem</span>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-400 font-semibold mb-2">Preço: {{ $product->price }}€</p>
                    <div class="flex justify-end items-center mt-4 gap-2">
                        <a href="{{ url('products/' . $product->id) }}" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-700 dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                        @can('update', $product)
                            <a href="{{ url('products/' . $product->id . '/edit') }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-700 dark:bg-gray-500 dark:hover:bg-gray-400">Editar</a>
                        @endcan
                        @can('delete', $product)
                            <form id="delete-form" action="{{ url('products/' . $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500" id="delete-button">Eliminar</button>
                            </form>

                            <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                <div class="bg-white p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                    <h2 class="text-xl font-bold mb-4">Pretende eliminar?</h2>
                                    <p class="mb-4 dark:text-red-300">Não poderá reverter isso!</p>
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
    document.getElementById('delete-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.remove('hidden');
    });

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById('delete-form').submit();
    });
</script>
