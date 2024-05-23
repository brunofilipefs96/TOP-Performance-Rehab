<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 text-white">Lista de Produtos</h1>
    @can('create', App\Models\Product::class)
        <a href="{{ url('products/create') }}" class="block mb-4">
            <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-700">Adicionar Produto</button>
        </a>
    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @foreach ($products as $product)
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md text-white">
                <div class="flex justify-center">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-600 flex items-center justify-center">
                            <span class="text-3xl">Sem imagem</span>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-400 mb-2">{{ $product->price }}</p>
                    <div class="flex justify-between items-center">
                        <a href="{{ url('products/' . $product->id) }}" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-700">Mostrar</a>
                        @can('update', $product)
                            <a href="{{ url('products/' . $product->id . '/edit') }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-700">Editar</a>
                        @endcan
                        @can('delete', $product)
                            <form action="{{url('products/' . $product->id)}}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-700">Eliminar</button>
                            </form>
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
