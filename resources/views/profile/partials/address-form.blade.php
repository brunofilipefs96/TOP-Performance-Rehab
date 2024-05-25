<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Moradas') }}
        </h2>
    </header>
    @if ($user->hasAddress())
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Minhas Moradas.") }}
        </p>

        <!-- Seleção de Morada -->
        <div>
            <x-input-label for="address" :value="__('Selecionar Morada')" />
            <select id="address" name="address" class="mt-1 block w-full" onchange="updateAddressFields()">
                @foreach($user->addresses as $address)
                    <option value="{{ $address->id }}" @if($loop->first) selected @endif>{{ $address->name }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <form method="post" action="{{ route('address.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

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
                <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Guardado.') }}</p>
                @endif
            </div>
        </form>
    @else
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Ainda não possui nenhuma morada.") }}
        </p>

        <h2 class="mt-10">Inserir Morada</h2>
        <form method="post" action="{{ route('address.store') }}" class="mt-6 space-y-6">
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
                <button type="submit" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Inserir Morada</button>
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

        function updateAddressFields() {
            const addressId = document.getElementById('address').value;
            const addresses = @json($user->addresses);

            const selectedAddress = addresses.find(address => address.id == addressId);

            document.getElementById('name').value = selectedAddress.name;
            document.getElementById('street').value = selectedAddress.street;
            document.getElementById('city').value = selectedAddress.city;
            document.getElementById('postal_code').value = selectedAddress.postal_code;
        }
    </script>
</section>
