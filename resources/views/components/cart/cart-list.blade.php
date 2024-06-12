<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold my-4 text-gray-900 dark:text-gray-200">Cart</h1>
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
        <div class="dark:bg-lime-300 bg-blue-400 text-white p-4 rounded mb-4">
            {{ session('warning') }}
        </div>
    @endif

    @php
        $cart = session()->get('cart', []);
    @endphp

    @if(count($cart) > 0)
        <table class="w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
            <thead>
            <tr>
                <th class="p-4">Product</th>
                <th class="p-4">Quantity</th>
                <th class="p-4">Price</th>
                <th class="p-4">Total</th>
                <th class="p-4">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cart as $id => $details)
                <tr>
                    <td class="p-4 text-center">
                        <a href="{{ route('products.show', $id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                            {{ $details['name'] }}
                        </a>
                    </td>
                    <td class="p-4 text-center flex items-center justify-center">
                        <form action="{{ route('cart.decrease', $id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="mr-3 bg-red-300 text-black px-2 py-1 rounded-md"> - </button>
                        </form>
                        <span class="mx-2">{{ $details['quantity'] }}</span>
                        <form action="{{ route('cart.increase', $id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="ml-3 bg-blue-300 dark:bg-lime-300 text-black px-2 py-1 rounded-md">+</button>
                        </form>
                    </td>
                    <td class="p-4 text-center">${{ $details['price'] }}</td>
                    <td class="p-4 text-center">${{ $details['price'] * $details['quantity'] }}</td>
                    <td class="p-4 text-center">
                        <!-- Form to remove product from cart -->
                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <div class="mt-4 flex justify-end">
            <a href="{{ route('products.index') }}" class="dark:bg-lime-400 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Continue Shopping</a>
            <a href="#" class="bg-green-600 text-white px-4 py-2 ml-4 rounded-md hover:bg-green-700">Checkout</a>
        </div>
    @else
        <div class="dark:bg-gray-800 bg-gray-400 text-white p-4 rounded-xl">
            Your cart is empty.
        </div>
        <div class="mt-4">
            <a href="{{ route('products.index') }}" class="dark:bg-lime-400 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Continue Shopping</a>
        </div>
    @endif
</div>
