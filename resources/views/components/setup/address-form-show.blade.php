<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
                <span class="step active">
                    <span class="number">1</span>
                    <span class="text">Morada</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number">2</span>
                    <span class="text">Matrícula</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number">3</span>
                    <span class="text">Modalidades</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number">4</span>
                    <span class="text">Seguro</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number">5</span>
                    <span class="text last">Pagamento</span>
                </span>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-4xl dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Moradas</h1>
            </div>
            <form action="{{ route('setup.address.store') }}" method="POST">
                @csrf
                @if ($user->addresses && $user->addresses->count() > 0)
                    <div id="select_address_section">
                        <label for="address" class="block text-sm font-medium text-gray-800 dark:text-gray-200 mt-5 mb-1">Selecionar Morada</label>
                        <select id="address" name="address_id" class="w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm" onchange="updateAddressFields()">
                            @foreach($user->addresses as $address)
                                <option value="{{ $address->id }}">{{ $address->name }} - {{ $address->street }}, {{ $address->city }} ({{ $address->postal_code }})</option>
                            @endforeach
                        </select>
                        @error('address_id')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="mt-4 text-gray-600 dark:text-gray-400">
                            Se quiser fazer alguma alteração da morada, vá ao perfil alterar.
                        </div>
                    </div>
                    <div id="existing_address_fields" class="mt-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome da Morada</label>
                            <input type="text" id="existing_name" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                            <input type="text" id="existing_street" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                            <input type="text" id="existing_city" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                            <input type="text" id="existing_postal_code" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white" readonly>
                        </div>
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
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_street" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                            <input type="text" id="new_street" name="street" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('street') border-red-500 @enderror" value="{{ old('street') }}" autocomplete="street" maxlength="100">
                            @error('street')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_city" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                            <input type="text" id="new_city" name="city" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('city') border-red-500 @enderror" value="{{ old('city') }}" autocomplete="city" maxlength="50">
                            @error('city')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_postal_code" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                            <input type="text" id="new_postal_code" name="postal_code" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('postal_code') border-red-500 @enderror" value="{{ old('postal_code') }}" pattern="\d{4}-\d{3}" autocomplete="postal_code" maxlength="8">
                            @error('postal_code')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Avançar</button>
                    </div>
                @else
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Ainda não possui nenhuma morada.") }}
                    </p>

                    <div class="flex items-center">
                        <input type="hidden" name="new_address" value="on">
                        <div id="new_address_fields" class="mt-4">
                            <div class="mb-4">
                                <label for="new_name" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome da Morada</label>
                                <input type="text" id="new_name" name="name" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('name') border-red-500 @enderror" value="{{ old('name') }}" autocomplete="name" maxlength="50">
                                @error('name')
                                <span class="text-red-500 text-sm mt-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="new_street" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                                <input type="text" id="new_street" name="street" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('street') border-red-500 @enderror" value="{{ old('street') }}" autocomplete="street" maxlength="100">
                                @error('street')
                                <span class="text-red-500 text-sm mt-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="new_city" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                                <input type="text" id="new_city" name="city" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('city') border-red-500 @enderror" value="{{ old('city') }}" autocomplete="city" maxlength="50">
                                @error('city')
                                <span class="text-red-500 text-sm mt-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="new_postal_code" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                                <input type="text" id="new_postal_code" name="postal_code" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500 dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 @error('postal_code') border-red-500 @enderror" value="{{ old('postal_code') }}" pattern="\d{4}-\d{3}" autocomplete="postal_code" maxlength="8">
                                @error('postal_code')
                                <span class="text-red-500 text-sm mt-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Avançar</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    const newAddressCheckbox = document.getElementById('new_address');
    if (newAddressCheckbox) {
        newAddressCheckbox.addEventListener('change', function() {
            document.getElementById('new_address_fields').classList.toggle('hidden', !this.checked);
            document.getElementById('existing_address_fields').classList.toggle('hidden', this.checked);
            document.getElementById('select_address_section').classList.toggle('hidden', this.checked);

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

    function updateAddressFields() {
        if (!document.getElementById('address')) {
            return;
        } else {
            var selectedAddressId = document.getElementById('address').value;
            var addresses = {!! json_encode($user->addresses) !!};
            var selectedAddress = addresses.find(function(address) {
                return address.id == selectedAddressId;
            });

            document.getElementById('existing_name').value = selectedAddress.name;
            document.getElementById('existing_street').value = selectedAddress.street;
            document.getElementById('existing_city').value = selectedAddress.city;
            document.getElementById('existing_postal_code').value = selectedAddress.postal_code;
        }
    }

    @if ($errors->any())
    document.getElementById('new_address_fields').classList.remove('hidden');
    @endif

    updateAddressFields();
</script>
