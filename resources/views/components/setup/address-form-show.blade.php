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
        <div class="w-full max-w-2xl bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <header>
                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Moradas') }}
                </h2>
            </header>

            @if ($user->addresses && $user->addresses->count() > 0)
                <!-- Seleção de Morada -->
                <div>
                    <x-input-label for="address" :value="__('Minhas Moradas')" class="mt-5 mb-1"/>
                    <select id="address" name="address" class="w-1/2 dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm" onchange="updateAddressFields()">
                        @foreach($user->addresses as $address)
                            <option value="{{ $address->id }}" @if($loop->first) selected @endif>{{ $address->name }}</option>
                        @endforeach
                    </select>
                    @error('address')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
                <div class="flex items-center">
                    <button id="create-address-button" type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150" onclick="createAddress()">Inserir Morada</button>
                </div>
                <h1 id="form-title" class="text-lg mt-10 text-gray-800 dark:text-gray-200">Atualizar Morada</h1>
                <form id="updateAddressForm" method="POST" action="{{ route('addresses.update', $user->addresses->first()->id) }}" class="mt-2 space-y-6">
                    @csrf
                    @method('put')

                    <!-- Nome da Morada -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome da Morada</label>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->addresses->first()->name)" required autofocus autocomplete="name" maxlength="50" />
                        @error('name')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <!-- Rua -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                        <x-text-input id="street" name="street" type="text" class="mt-1 block w-full" :value="old('street', $user->addresses->first()->street)" required autocomplete="street" maxlength="100" />
                        @error('street')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <!-- Cidade -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->addresses->first()->city)" required autocomplete="city" maxlength="50" />
                        @error('city')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <!-- Código Postal -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                        <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" pattern="\d{4}-\d{3}" :value="old('postal_code', $user->addresses->first()->postal_code)" required autocomplete="postal_code" maxlength="8" />
                        @error('postal_code')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <form id="delete-form" action="" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" id="delete-button" onclick="confirmDelete()">Eliminar</button>
                        </form>
                        <button id="submit-button" type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">Atualizar</button>
                    </div>
                </form>
                @if ($user->addresses && $user->addresses->count() > 0)
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('setup.membershipShow') }}" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Avançar</a>
                    </div>
                @endif
            @else
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __("Ainda não possui nenhuma morada.") }}
                </p>

                <div class="flex items-center">
                    <button id="create-address-button" type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150 " onclick="createAddress()">Inserir Morada</button>
                </div>
            @endif

            <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
                    <p class="mb-4 dark:text-red-300 text-red-500">Não poderá reverter isso!</p>
                    <div class="flex justify-end gap-4">
                        <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                        <button id="confirm-button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Eliminar</button>
                    </div>
                </div>
            </div>

            <!-- Criar Morada Modal -->
            <div id="create-address-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 @if ($errors->any()) block @else hidden @endif">
                <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                    <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Inserir Morada</h2>
                    <form id="createAddressForm" method="POST" action="{{ route('addresses.store') }}" class="mt-2 space-y-6">
                        @csrf

                        <!-- Nome da Morada -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome da Morada</label>
                            <x-text-input id="create_name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required autofocus autocomplete="name" maxlength="50" />
                            @error('name')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>

                        <!-- Rua -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                            <x-text-input id="create_street" name="street" type="text" class="mt-1 block w-full" value="{{ old('street') }}" required autocomplete="street" maxlength="100" />
                            @error('street')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>

                        <!-- Cidade -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                            <x-text-input id="create_city" name="city" type="text" class="mt-1 block w-full" value="{{ old('city') }}" required autocomplete="city" maxlength="50" />
                            @error('city')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>

                        <!-- Código Postal -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                            <x-text-input id="create_postal_code" name="postal_code" type="text" class="mt-1 block w-full" pattern="\d{4}-\d{3}" value="{{ old('postal_code') }}" required autocomplete="postal_code" maxlength="8" />
                            @error('postal_code')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button id="confirm-create-address-button" type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Criar</button>
                            <button id="cancel-create-address-button" type="button" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 dark:bg-gray-400 dark:text-gray-900 dark:hover:bg-gray-300">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let addressDeleted = 0;

    if (document.getElementById('address') !== null) {
        document.getElementById('postal_code').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4, 7);
            } else {
                document.getElementById('create-address-modal').classList.remove('hidden');
            }
            e.target.value = value.slice(0, 8);
        });
        document.getElementById('create-address-button').innerHTML = 'Inserir Nova Morada';
    }

    document.getElementById('create_postal_code').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) {
            value = value.slice(0, 4) + '-' + value.slice(4, 7);
        }
        e.target.value = value.slice(0, 8);
    });

    function createAddress() {
        document.getElementById('create-address-modal').classList.remove('hidden');
    }

    function confirmDelete() {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        addressDeleted = document.getElementById('address').value;
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById('delete-form').action = "{{ url('profile/addresses') }}/" + addressDeleted;
        document.getElementById('delete-form').submit();
    });

    document.getElementById('cancel-create-address-button').addEventListener('click', function() {
        document.getElementById('create-address-modal').classList.add('hidden');
    });

    document.getElementById('confirm-create-address-button').addEventListener('click', function() {
        document.getElementById('createAddressForm').submit();
    });

    function updateAddressFields() {
        if (!document.getElementById('address')) {
            return;
        } else {
            var selectedAddressId = document.getElementById('address').value;
            var addresses = {!! json_encode($user->addresses) !!};
            var selectedAddress = addresses.find(function(address) {
                return address.id == selectedAddressId;
            });

            document.getElementById('name').value = selectedAddress.name;
            document.getElementById('street').value = selectedAddress.street;
            document.getElementById('city').value = selectedAddress.city;
            document.getElementById('postal_code').value = selectedAddress.postal_code;

            document.getElementById('updateAddressForm').action = "{{ route('addresses.update', '') }}/" + selectedAddressId;

        }
    }

    @if ($errors->any())
    document.getElementById('create-address-modal').classList.remove('hidden');
    @endif

    updateAddressFields();
</script>
