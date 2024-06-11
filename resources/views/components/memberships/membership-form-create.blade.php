<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <div class="flex justify-center mb-5">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Adicionar Membership</h1>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-800 dark:text-white">Nome</label>
                <input type="text" value="{{ Auth::user()->full_name }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <header>
                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Moradas') }}
                </h2>
            </header>

            @if ($addresses && $addresses->count() > 0)
                <!-- Seleção de Morada -->
                <div>
                    <x-input-label for="address" :value="__('Minhas Moradas')" class="mt-5 mb-1"/>
                    <select id="address" name="address" class="w-1/2 dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm" onchange="updateAddressFields()">
                        @foreach($addresses as $address)
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
                <div class="mb-4">
                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Plano Mensal</label>
                    <div class="flex items-center">
                        <input type="radio" id="monthly_plan_yes" name="monthly_plan" value="1"
                               class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500"
                               {{ old('monthly_plan') == '1' ? 'checked' : '' }} required>
                        <label for="monthly_plan_yes" class="ml-2 dark:text-gray-200 text-gray-800">Sim</label>
                    </div>
                    <div class="flex items-center mt-2">
                        <input type="radio" id="monthly_plan_no" name="monthly_plan" value="0"
                               class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500"
                               {{ old('monthly_plan') == '0' ? 'checked' : '' }} required>
                        <label for="monthly_plan_no" class="ml-2 dark:text-gray-200 text-gray-800">Não</label>
                    </div>
                    @error('monthly_plan')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex items-center mt-6">
                    <a href="{{ url('entries/1/fill') }}">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                            Preencher Formulario
                        </button>
                    </a>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="submit"
                            class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">
                        Adicionar
                    </button>
                    <a href="{{ url()->previous() }}"
                       class="inline-block bg-gray-500 mt-4 mb-5 py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 text-white">
                        Cancelar
                    </a>
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
            var addresses = {!! json_encode($addresses) !!};
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
