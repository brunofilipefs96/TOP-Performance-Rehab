<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
                <span class="step complete">
                    <span class="number"><i class="fa-solid fa-check"></i></span>
                    <span class="text">Morada</span>
                    <span class="spacer"></span>
                </span>
                <span class="step active">
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
                    {{ __('Adicionar Membership') }}
                </h2>
            </header>

            <div class="mb-4">
                <label for="name" class="block text-gray-800 dark:text-white">Nome</label>
                <input type="text" value="{{ Auth::user()->full_name }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

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
                </div>

                <!-- Campos de Morada -->
                <div class="mt-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome da Morada</label>
                        <input type="text" id="name" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" disabled>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                        <input type="text" id="street" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" disabled>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                        <input type="text" id="city" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" disabled>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                        <input type="text" id="postal_code" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" disabled>
                    </div>
                </div>
            @else
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __("Ainda não possui nenhuma morada.") }}
                </p>
            @endif

            <form method="POST" action="{{ route('memberships.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="address_id" id="address_id">
                <div class="flex items-center mt-6">
                    <a href="{{ url('entries/1/fill') }}">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                            Preencher Formulário
                        </button>
                    </a>
                </div>

                <div class="flex justify-between items-center gap-2">
                    <a href="{{ route('setup.addressShow') }}"
                       class="inline-block bg-gray-500 mt-4 mb-5 py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 text-white">
                        Voltar
                    </a>
                    <div class="flex gap-2">
                        @if($user->entries->count() > 0)
                            <button type="submit"
                                    class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">
                                Seguir
                            </button>
                        @else
                            <p class="mt-1 text-sm text-red-500">
                                {{ __("Você precisa preencher o formulário antes de adicionar um membership.") }}
                            </p>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
            document.getElementById('address_id').value = selectedAddressId; // Atualiza o campo oculto
        }
    }

    updateAddressFields();
    document.getElementById('address').addEventListener('change', updateAddressFields); // Adiciona um listener para atualizar o campo oculto quando a seleção muda
</script>
