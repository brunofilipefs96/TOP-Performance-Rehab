<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold my-4 text-gray-900 dark:text-gray-200">Carrinho de Compras</h1>

    @if (session('error'))
        <div class="bg-red-500 text-white p-1 xs:p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="bg-yellow-500 text-black p-1 xs:p-4 rounded mb-4">
            {{ session('warning') }}
        </div>
    @endif

    @php
        $cart = session()->get('cart', []);
        $packCart = session()->get('packCart', []);
        $totalCart = 0;
        $totalPackCart = 0;
        $warnings = [];
        $hasShortages = false;

        foreach ($cart as $id => $details) {
            $product = App\Models\Product::find($id);
            $totalCart += $details['price'] * $details['quantity'];
            if ($product && $details['quantity'] > $product->quantity) {
                $hasShortages = true;
                $warnings[] = 'A quantidade de ' . $product->name . ' excede o estoque disponível.';
            }
        }

        foreach ($packCart as $details) {
            $totalPackCart += $details['price'] * $details['quantity'];
        }

        $totalGeral = $totalCart + $totalPackCart;
    @endphp

    @if(count($cart) > 0 || count($packCart) > 0)
        @if($hasShortages)
            <div class="text-xs sm:text-base bg-yellow-500 text-black p-1 xs:p-4 rounded mb-4">
                <p> <i class="fa-solid fa-triangle-exclamation text-black"></i> Os produtos assinalados no carrinho estão com falta de stock.</p>
                <p> A sua encomenda poderá demorar mais tempo a ser processada.</p>
            </div>
        @endif
        <div class="overflow-x-auto p-1 xs:p-4">
            <table class="text-xs xs:text-base  min-w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
                <thead>
                <tr>
                    <th class="p-1 xs:p-1 xs:p-4 text-left">Artigo</th>
                    <th class="p-1 xs:p-1 xs:p-4">Quantidade</th>
                    <th class="p-1 xs:p-4">Preço</th>
                    <th class="p-1 xs:p-4">Subtotal</th>
                    <th class="p-1 xs:p-4">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cart as $id => $details)
                    @php
                        $product = App\Models\Product::find($id);
                        $isShortage = $product && $details['quantity'] > $product->quantity;
                    @endphp
                    <tr>
                        <td class="p-1 xs:p-4 text-left">
                            @if(isset($details['name']))
                                <a href="{{ route('products.show', $id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                    <i class="fa-solid fa-basket-shopping mr-2"></i>{{ $details['name'] }}
                                    @if($isShortage)
                                        <i class="fa-solid fa-triangle-exclamation text-yellow-500 dark:text-yellow-300 ml-1"></i>
                                    @endif
                                </a>
                            @else
                                <span>Produto não encontrado</span>
                            @endif
                        </td>
                        <td class="p-1 xs:p-4 text-center flex items-center justify-center">
                            <form action="{{ route('cart.decreaseProduct', $id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="mr-1 bg-gray-400 text-black px-2 py-1 rounded-md text-xs">-</button>
                            </form>
                            <span class="mx-2">{{ $details['quantity'] ?? 'N/A' }}</span>
                            <form action="{{ route('cart.increaseProduct', $id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="ml-1 bg-gray-400 text-black px-2 py-1 rounded-md text-xs">+</button>
                            </form>
                        </td>
                        <td class="p-1 xs:p-4 text-center">{{ number_format($details['price'], 2) ?? 'N/A' }} €</td>
                        <td class="p-1 xs:p-4 text-center">{{ isset($details['price'], $details['quantity']) ? number_format($details['price'] * $details['quantity'], 2) : 'N/A' }} €</td>
                        <td class="p-1 xs:p-4 text-center">
                            <form action="{{ route('cart.removeProduct', $id) }}" method="POST" class="inline">
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
                        <td class="p-1 xs:p-4 text-left">
                            @if(isset($details['name']))
                                <a href="{{ route('packs.show', $id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                    <i class="fa-solid fa-box mr-2"></i>{{ $details['name'] }}
                                </a>
                            @else
                                <span>Pack não encontrado</span>
                            @endif
                        </td>
                        <td class="p-1 xs:p-4 text-center">
                            <span class="mx-2">{{ $details['quantity'] ?? 'N/A' }}</span>
                        </td>
                        <td class="p-1 xs:p-4 text-center">{{ number_format($details['price'], 2) ?? 'N/A' }} €</td>
                        <td class="p-1 xs:p-4 text-center">{{ isset($details['price'], $details['quantity']) ? number_format($details['price'] * $details['quantity'], 2) : 'N/A' }} €</td>
                        <td class="p-1 xs:p-4 text-center">
                            <form action="{{ route('cart.removePack', $id) }}" method="POST" class="inline">
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
        <div class="mt-4 pt-4 border-t-2 border-gray-400">
            <div class="flex justify-end items-center text-gray-800 dark:text-gray-100">
                <span class="text-lg font-bold mr-2">Total:</span>
                <span class="text-base xs:text-lg font-bold">{{ number_format($totalGeral, 2) }} €</span>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ route('products.index') }}" class="text-sm xs:text-lg dark:bg-gray-500 bg-blue-400 text-white px-4 py-2 rounded-md hover:bg-blue-600 dark:hover:bg-gray-600">Continuar a Comprar</a>
            <a href="{{ route('cart.checkout') }}" class="text-sm xs:text-lg bg-green-600 text-white px-4 py-2 ml-4 rounded-md hover:bg-green-700">Finalizar Compra</a>
        </div>
    @else
        <div class="dark:bg-gray-800 bg-gray-400 text-white p-1 xs:p-4 rounded-xl">
            Ainda não adicionou nenhum produto.
        </div>
        <div class="mt-6">
            <a href="{{ route('products.index') }}" class="dark:bg-lime-400 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Continuar a Comprar</a>
        </div>
    @endif
</div>
