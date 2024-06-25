<div class="container mx-auto mt-5 p-5 glass rounded-lg shadow-md bg-white dark:bg-gray-800">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Encomenda nº {{ $sale->id }}</h1>
        <hr class="border-gray-400 dark:border-gray-600">
    </div>

    <!-- Dados do Cliente -->
    <div class="mb-6">
        @if(auth()->id() == $sale->user_id)
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Os seus dados</h2>
        @else
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Dados do Cliente</h2>
        @endif
        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md">
            <p><strong class="text-gray-800 dark:text-gray-200">Nome:</strong> <span class="text-gray-900 dark:text-gray-300">{{ $sale->user->full_name ?? 'N/A' }}</span></p>
            <p><strong class="text-gray-800 dark:text-gray-200">Rua:</strong> <span class="text-gray-900 dark:text-gray-300">{{ $sale->address->street ?? 'N/A' }}, {{ $sale->address->city ?? 'N/A' }}</span></p>
            <p><strong class="text-gray-800 dark:text-gray-200">Código Postal:</strong> <span class="text-gray-900 dark:text-gray-300">{{ $sale->address->postal_code ?? 'N/A' }}</span></p>
        </div>
    </div>

    <!-- Dados da Encomenda -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Dados da Encomenda</h2>
        <div class="overflow-x-auto p-4 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md">
            <table class="min-w-full bg-gray-200 dark:bg-gray-700 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
                <thead>
                <tr>
                    <th class="p-4 text-left">Artigo</th>
                    <th class="p-4 text-center">Quantidade</th>
                    @if(auth()->user()->hasRole('admin'))
                        <th class="p-4 text-center">Quantidade em Falta</th>
                    @endif
                    <th class="p-4 text-center">Preço</th>
                    <th class="p-4 text-center">Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sale->products as $product)
                    <tr class="{{ $product->pivot->quantity_shortage > 0 ? 'bg-red-100 dark:bg-red-900' : '' }}">
                        <td class="p-4 text-left">
                            <a href="{{ route('products.show', $product->id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                <i class="fa-solid fa-basket-shopping mr-2"></i>
                                @if($product->pivot->quantity_shortage > 0)
                                    <i class="fa-solid fa-triangle-exclamation text-yellow-500 dark:text-yellow-300 mr-1"></i>
                                @endif
                                {{ $product->name }}
                            </a>
                        </td>
                        <td class="p-4 text-center">{{ $product->pivot->quantity }}</td>
                        @if(auth()->user()->hasRole('admin'))
                            <td class="p-4 text-center {{ $product->pivot->quantity_shortage > 0 ? 'text-red-500' : '' }}">
                                {{ $product->pivot->quantity_shortage }}
                            </td>
                        @endif
                        <td class="p-4 text-center">{{ number_format($product->pivot->price, 2) }} €</td>
                        <td class="p-4 text-center">{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }} €</td>
                    </tr>
                @endforeach
                @foreach($sale->packs as $pack)
                    <tr>
                        <td class="p-4 text-left">
                            <a href="{{ route('packs.show', $pack->id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                <i class="fa-solid fa-box mr-2"></i>{{ $pack->name }}
                            </a>
                        </td>
                        <td class="p-4 text-center">{{ $pack->pivot->quantity }}</td>
                        @if(auth()->user()->hasRole('admin'))
                            <td class="p-4 text-center">N/A</td>
                        @endif
                        <td class="p-4 text-center">{{ number_format($pack->pivot->price, 2) }} €</td>
                        <td class="p-4 text-center">{{ number_format($pack->pivot->price * $pack->pivot->quantity, 2) }} €</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 pt-4 border-t-2 border-gray-400 dark:border-gray-600">
            <div class="flex justify-end items-center text-gray-800 dark:text-gray-100">
                <span class="text-lg font-bold mr-2">Total:</span>
                <span class="text-lg font-bold">{{ number_format($sale->total, 2) }} €</span>
            </div>
        </div>
    </div>

    <!-- Estado da Encomenda -->
    <div>
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Estado da Encomenda</h2>
        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md">
            <p><strong class="text-gray-800 dark:text-gray-200">Estado:</strong> <span class="text-gray-900 dark:text-gray-300">{{ $sale->translated_status }}</span></p>
        </div>
    </div>

    @if(auth()->id() == $sale->user_id && $sale->products->where('pivot.quantity_shortage', '>', 0)->count() > 0)
        <div class="p-4 mt-4 bg-yellow-200 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-200 rounded-lg shadow-md">
            <p>Alguns dos produtos que encomendou estão em falta. O seu pedido poderá demorar mais tempo.</p>
        </div>
    @endif
</div>
