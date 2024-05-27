<section>
    <header>
        <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">
            {{ __('Moradas') }}
        </h2>
    </header>
    @if ($user->addresses && $user->addresses->count() > 0)
        <div class="flex items-center gap-4 mt-4">
            <button type="button" onclick="adicionarEndereco()" class="bg-green-500 dark:text-white text-gray-800 py-2 px-4 rounded-md shadow-sm hover:bg-green-700 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Adicionar Morada</button>
        </div>

        <!-- Seleção de Morada -->
        <div>
            <x-input-label for="address" :value="__('Minhas Moradas')" class="mt-5 mb-1"/>
            <select id="address" name="address" class="w-1/2 dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 dark:text-gray-900 focus:border-lime-500 dark:focus:border-lime-600 focus:ring-lime-500 dark:focus:ring-lime-600 rounded-md shadow-sm" onchange="updateAddressFields()">
                @foreach($user->addresses as $address)
                    <option value="{{ $address->id }}" @if($loop->first) selected @endif>{{ $address->name }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>
        <h1 id="form-title" class="text-lg mt-10">Atualizar Morada</h1>
        <form id="updateAddressForm" method="POST" action="{{ route('addresses.update', $user->addresses->first()->id) }}" class="mt-2 space-y-6">
            @csrf
            @method('put')

            <!-- Nome da Morada -->
            <div>
                <x-input-label for="name" :value="__('Nome da Morada')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->addresses->first()->name)" required autofocus autocomplete="name" maxlength="50" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Rua -->
            <div>
                <x-input-label for="street" :value="__('Rua')" />
                <x-text-input id="street" name="street" type="text" class="mt-1 block w-full" :value="old('street', $user->addresses->first()->street)" required autocomplete="street" maxlength="100" />
                <x-input-error class="mt-2" :messages="$errors->get('street')" />
            </div>

            <!-- Cidade -->
            <div>
                <x-input-label for="city" :value="__('Cidade')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->addresses->first()->city)" required autocomplete="city" maxlength="50" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            <!-- Código Postal -->
            <div>
                <x-input-label for="postal_code" :value="__('Código Postal')" />
                <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" pattern="\d{4}-\d{3}" :value="old('postal_code', $user->addresses->first()->postal_code)" required autocomplete="postal_code" maxlength="8" />
                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
            </div>

            <div class="flex items-center gap-4">
                <button id="submit-button" type="submit" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Atualizar</button>
            </div>
        </form>
        <form id="delete-form" method="POST" action="" class="inline">
            @csrf
            @method('DELETE')
            <button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500" onclick="removerEndereco()">Eliminar</button>
            <button type="submit" id="delete-submit-button" style="display: none;"></button>
        </form>
    @else
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Ainda não possui nenhuma morada.") }}
        </p>

        <h2 class="mt-10 dark:text-white text-gray-800">Inserir Morada</h2>
        <form method="post" action="{{ url('profile/addresses') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Nome da Morada')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" maxlength="50" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="street" :value="__('Rua')" />
                <x-text-input id="street" name="street" type="text" class="mt-1 block w-full" :value="old('street')" required autocomplete="street" maxlength="100" />
                <x-input-error class="mt-2" :messages="$errors->get('street')" />
            </div>

            <div>
                <x-input-label for="city" :value="__('Cidade')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city')" required autocomplete="city" maxlength="50" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            <div>
                <x-input-label for="postal_code" :value="__('Código Postal')" />
                <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" pattern="\d{4}-\d{3}" :value="old('postal_code')" required autocomplete="postal_code" maxlength="8" />
                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Inserir</button>
            </div>
        </form>
    @endif

    <script>
        document.getElementById('postal_code').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4, 7);
            }
            e.target.value = value.slice(0, 8);
        });

        function removerEndereco() {
            var selectedAddressId = document.getElementById('address').value;
            document.getElementById('delete-form').action = "{{ url('profile/addresses') }}/" + selectedAddressId;
            document.getElementById('delete-submit-button').click();
        }

        function updateAddressFields() {
            var selectedAddressId = document.getElementById('address').value;
            var selectedAddress = {!! $user->addresses !!}.find(function(address) {
                return address.id == selectedAddressId;
            });

            document.getElementById('name').value = selectedAddress.name;
            document.getElementById('street').value = selectedAddress.street;
            document.getElementById('city').value = selectedAddress.city;
            document.getElementById('postal_code').value = selectedAddress.postal_code;

            document.getElementById('updateAddressForm').action = "{{ route('addresses.update', '') }}/" + selectedAddressId;
            document.getElementById('submit-button').textContent = 'Atualizar';
            document.getElementById('form-title').textContent = 'Atualizar Morada';
        }

        function adicionarEndereco() {
            document.getElementById('name').value = '';
            document.getElementById('street').value = '';
            document.getElementById('city').value = '';
            document.getElementById('postal_code').value = '';
            document.getElementById('updateAddressForm').action = "{{ url('profile/addresses') }}";
            document.getElementById('updateAddressForm').method = "POST";
            document.getElementById('submit-button').textContent = 'Adicionar Morada';
            document.getElementById('form-title').textContent = 'Adicionar Morada';
        }

        updateAddressFields();
    </script>
</section>
