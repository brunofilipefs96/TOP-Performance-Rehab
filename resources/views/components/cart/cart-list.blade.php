<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold my-4 text-gray-900 dark:text-gray-200">Carrinho de Compras</h1>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="dark:bg-gray-800 bg-gray-300 dark:text-white text-gray-800 p-4 rounded mb-4">
            {{ session('warning') }}
        </div>
    @endif

    @php
        $cart = session()->get('cart', []);
        $packCart = session()->get('packCart', []);
    @endphp

    @if(count($cart) > 0 || count($packCart) > 0)
        <div class="overflow-x-auto p-4">
            <table class="min-w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
                <thead>
                <tr>
                    <th class="p-4">Artigo</th>
                    <th class="p-4">Quantidade</th>
                    <th class="p-4">Preço</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cart as $id => $details)
                    <tr>
                        <td class="p-4 text-center">
                            @if(isset($details['name']))
                                <a href="{{ route('products.show', $id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                    {{ $details['name'] }}
                                </a>
                            @else
                                <span>Produto não encontrado</span>
                            @endif
                        </td>
                        <td class="p-4 text-center flex items-center justify-center">
                            <form action="{{ route('cart.decrease', $id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="mr-1 bg-gray-400 text-black px-2 py-1 rounded-md text-xs">-</button>
                            </form>
                            <span class="mx-2">{{ $details['quantity'] ?? 'N/A' }}</span>
                            <form action="{{ route('cart.increase', $id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="ml-1 bg-gray-400 text-black px-2 py-1 rounded-md text-xs">+</button>
                            </form>
                        </td>
                        <td class="p-4 text-center">{{ $details['price'] ?? 'N/A' }} €</td>
                        <td class="p-4 text-center">{{ isset($details['price'], $details['quantity']) ? $details['price'] * $details['quantity'] : 'N/A' }} €</td>
                        <td class="p-4 text-center">
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-700">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @foreach($packCart as $id => $details)
                    <tr>
                        <td class="p-4 text-center">
                            @if(isset($details['name']))
                                <a href="{{ route('packs.show', $id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                    {{ $details['name'] }}
                                </a>
                            @else
                                <span>Pack não encontrado</span>
                            @endif
                        </td>
                        <td class="p-4 text-center flex items-center justify-center">
                            <span class="mx-2">{{ $details['quantity'] ?? 'N/A' }}</span>
                        </td>
                        <td class="p-4 text-center">{{ $details['price'] ?? 'N/A' }} €</td>
                        <td class="p-4 text-center">{{ isset($details['price'], $details['quantity']) ? $details['price'] * $details['quantity'] : 'N/A' }} €</td>
                        <td class="p-4 text-center">
                            <form action="{{ route('packCart.remove', $id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-700">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ route('products.index') }}" class="dark:bg-gray-500 bg-blue-400 text-white px-4 py-2 rounded-md hover:bg-blue-600">Continuar a Comprar</a>
            <a href="#" class="bg-green-600 text-white px-4 py-2 ml-4 rounded-md hover:bg-green-700">Finalizar Compra</a>
        </div>
    @else
        <div class="dark:bg-gray-800 bg-gray-400 text-white p-4 rounded-xl">
            Ainda não adicionou nenhum produto.
        </div>
        <div class="mt-6">
            <a href="{{ route('products.index') }}" class="dark:bg-lime-400 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Continuar a Comprar</a>
        </div>
    @endif
</div>
