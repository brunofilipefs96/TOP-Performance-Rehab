<!-- resources/views/pages/cart/checkout.blade.php -->

<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-4xl dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('cart.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Checkout</h1>
            </div>
            <form id="checkout-form" action="{{ route('cart.processCheckout') }}" method="POST" onsubmit="disableConfirmButton(this)">
                @csrf

                @if ($addresses->isEmpty())
                    <input type="hidden" name="new_address" value="on">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Morada</h2>
                    </div>
                    <div id="new_address_fields" class="mt-4">
                        <div class="mb-4">
                            <label for="new_name" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome da Morada</label>
                            <input type="text" id="new_name" name="name" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required autocomplete="name" maxlength="50">
                            @error('name')
                            <span class="text-red-500 text-sm mt-2" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_street" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                            <input type="text" id="new_street" name="street" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('street') border-red-500 @enderror" value="{{ old('street') }}" required autocomplete="street" maxlength="100">
                            @error('street')
                            <span class="text-red-500 text-sm mt-2" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_city" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                            <input type="text" id="new_city" name="city" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('city') border-red-500 @enderror" value="{{ old('city') }}" required autocomplete="city" maxlength="50">
                            @error('city')
                            <span class="text-red-500 text-sm mt-2" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_postal_code" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                            <input type="text" id="new_postal_code" name="postal_code" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('postal_code') border-red-500 @enderror" value="{{ old('postal_code') }}" pattern="\d{4}-\d{3}" required autocomplete="postal_code" maxlength="8">
                            @error('postal_code')
                            <span class="text-red-500 text-sm mt-2" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                @else
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-800 dark:text-gray-200 mt-5 mb-1">Selecionar Morada</label>
                        <select id="address" name="address_id" class="w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm">
                            @foreach($addresses as $address)
                                <option value="{{ $address->id }}">{{ $address->name }} - {{ $address->street }}, {{ $address->city }} ({{ $address->postal_code }})</option>
                            @endforeach
                        </select>
                        @error('address_id')
                        <span class="text-red-500 text-sm mt-2" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="flex items-center mt-4">
                        <input type="checkbox" id="new_address" name="new_address" class="mr-2" value="on">
                        <label for="new_address" class="text-gray-800 dark:text-gray-200">Usar nova morada</label>
                    </div>

                    <div id="new_address_fields" class="hidden mt-4">
                        <div class="mb-4">
                            <label for="new_name" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome da Morada</label>
                            <input type="text" id="new_name" name="name" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('name') border-red-500 @enderror" value="{{ old('name') }}" autocomplete="name" maxlength="50">
                            @error('name')
                            <span class="text-red-500 text-sm mt-2" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_street" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                            <input type="text" id="new_street" name="street" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('street') border-red-500 @enderror" value="{{ old('street') }}" autocomplete="street" maxlength="100">
                            @error('street')
                            <span class="text-red-500 text-sm mt-2" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_city" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                            <input type="text" id="new_city" name="city" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('city') border-red-500 @enderror" value="{{ old('city') }}" autocomplete="city" maxlength="50">
                            @error('city')
                            <span class="text-red-500 text-sm mt-2" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_postal_code" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                            <input type="text" id="new_postal_code" name="postal_code" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('postal_code') border-red-500 @enderror" value="{{ old('postal_code') }}" pattern="\d{4}-\d{3}" autocomplete="postal_code" maxlength="8">
                            @error('postal_code')
                            <span class="text-red-500 text-sm mt-2" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block text-gray-800 dark:text-white mt-4">NIF</label>
                    <div class="mt-1 flex flex-col sm:flex-row">
                        <label class="inline-flex items-center mr-4 mb-2 sm:mb-0">
                            <input type="radio" name="nif_option" value="personal" checked class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500">
                            <span class="ml-2 dark:text-gray-200 text-gray-800">Usar meu NIF</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="nif_option" value="final" class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500">
                            <span class="ml-2 dark:text-gray-200 text-gray-800">Consumidor Final</span>
                        </label>
                    </div>
                </div>

                <!-- Método de Pagamento -->
                <div class="mb-4 mt-4">
                    <label class="block text-gray-800 dark:text-white">Método de Pagamento</label>
                    <div class="mt-1 p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm bg-gray-100 dark:bg-gray-600 dark:text-white">
                        Referência Multibanco
                    </div>
                </div>


                <div class="flex justify-end mt-6">
                    <button type="submit" id="payment-button" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">Finalizar Compra</button>
                </div>
            </form>

            <div class="mt-10">
                <h2 class="text-xl font-bold text-gray-800 dark:text-lime-400 mb-4">Resumo do Carrinho</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
                        <thead>
                        <tr>
                            <th class="p-4 text-left">Artigo</th>
                            <th class="p-4">Quantidade</th>
                            <th class="p-4">Preço</th>
                            <th class="p-4">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $totalCart = 0;
                            $totalPackCart = 0;
                            $hasShortages = false;
                        @endphp
                        @foreach($cart as $id => $details)
                            @php
                                $product = App\Models\Product::find($id);
                                $isShortage = $product && $details['quantity'] > $product->quantity;
                                $totalCart += $details['price'] * $details['quantity'];
                                if ($isShortage) {
                                    $hasShortages = true;
                                }
                            @endphp
                            <tr>
                                <td class="p-4 text-left">
                                    <a href="{{ route('products.show', $id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                        <i class="fa-solid fa-basket-shopping mr-2"></i>{{ $details['name'] }}
                                        @if($isShortage)
                                            <i class="fa-solid fa-triangle-exclamation text-yellow-500 dark:text-yellow-300 ml-1"></i>
                                        @endif
                                    </a>
                                </td>
                                <td class="p-4 text-center">{{ $details['quantity'] ?? 'N/A' }}</td>
                                <td class="p-4 text-center">{{ number_format($details['price'], 2) ?? 'N/A' }} €</td>
                                <td class="p-4 text-center">{{ isset($details['price'], $details['quantity']) ? number_format($details['price'] * $details['quantity'], 2) : 'N/A' }} €</td>
                            </tr>
                        @endforeach
                        @foreach($packCart as $id => $details)
                            @php
                                $totalPackCart += $details['price'] * $details['quantity'];
                            @endphp
                            <tr>
                                <td class="p-4 text-left">
                                    <a href="{{ route('packs.show', $id) }}" class="dark:hover:text-lime-400 hover:text-blue-500">
                                        <i class="fa-solid fa-box mr-2"></i>{{ $details['name'] }}
                                    </a>
                                </td>
                                <td class="p-4 text-center">{{ $details['quantity'] ?? 'N/A' }}</td>
                                <td class="p-4 text-center">{{ number_format($details['price'], 2) ?? 'N/A' }} €</td>
                                <td class="p-4 text-center">{{ isset($details['price'], $details['quantity']) ? number_format($details['price'] * $details['quantity'], 2) : 'N/A' }} €</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 pt-4 border-t-2 border-gray-400 text-gray-700 dark:text-gray-200">
                    <div class="flex justify-end items-center">
                        <span class="text-lg font-bold mr-2">Total Geral:</span>
                        <span class="text-lg font-bold">{{ number_format($totalCart + $totalPackCart, 2) }} €</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const newAddressCheckbox = document.getElementById('new_address');
    if (newAddressCheckbox) {
        newAddressCheckbox.addEventListener('change', function() {
            document.getElementById('new_address_fields').classList.toggle('hidden', !this.checked);

            const newAddressFields = document.querySelectorAll('#new_address_fields input');
            newAddressFields.forEach(field => {
                field.required = this.checked;
            });
        });
    }

    const postalCodeInput = document.getElementById('new_postal_code');
    if (postalCodeInput) {
        postalCodeInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4, 7);
            }
            e.target.value = value.slice(0, 8);
        });
    }
</script>
