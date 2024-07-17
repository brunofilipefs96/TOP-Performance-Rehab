<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">1</span>
                    <span class="text text-gray-900 dark:text-white">Morada</span>
                    <span class="spacer"></span>
                </span>
                <span class="step active">
                    <span class="number text-gray-900 dark:text-white">2</span>
                    <span class="text text-gray-900 dark:text-white">Matrícula</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">3</span>
                    <span class="text text-gray-900 dark:text-white">Modalidades</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">4</span>
                    <span class="text text-gray-900 dark:text-white">Seguro</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">5</span>
                    <span class="text last text-gray-900 dark:text-white">Pagamento</span>
                </span>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-2xl bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Matrícula</h1>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-800 dark:text-white">Nome</label>
                <input type="text" value="{{ Auth::user()->full_name }}" disabled
                       class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <form id="membership-form" method="POST" action="{{ route('memberships.store') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                <input type="hidden" name="address_id" id="address_id">

                @if(!Auth::user()->cc_number)
                    <div class="mb-4">
                        <label for="cc_number" class="block text-gray-800 dark:text-white">Número de Cartão de Cidadão</label>
                        <input type="text" id="cc_number" name="cc_number"
                               class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                               value="{{ old('cc_number') }}" required>
                        @error('cc_number')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p id="cc_number_error" class="mt-1 text-sm text-red-500" style="display: none;">
                            {{ __("O número de Cartão de Cidadão deve ter 9 dígitos.") }}
                        </p>
                    </div>
                @else
                    <div class="mb-4">
                        <label for="cc_number" class="block text-gray-800 dark:text-white">Número de Cartão de Cidadão</label>
                        <input type="text" value="{{ Auth::user()->cc_number }}" disabled
                               class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                    </div>
                @endif

                <header>
                    <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Moradas') }}
                    </h2>
                </header>

                @if ($user->addresses && $user->addresses->count() > 0)
                    <!-- Seleção de Morada -->
                    <div>
                        <x-input-label for="address" :value="__('Minhas Moradas')" class="mt-5 mb-1"/>
                        <select id="address" name="address"
                                class="w-1/2 dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                                onchange="updateAddressFields()">
                            @foreach($user->addresses as $address)
                                <option value="{{ $address->id }}"
                                        @if($loop->first) selected @endif>{{ $address->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Label de Verificação de Morada -->
                    <div id="address-check-label" class="mt-2 text-sm dark:text-yellow-500 text-gray-700" style="display: none;">
                        Por favor, certifique-se de que a morada selecionada é a que pretende vincular à sua matrícula.
                    </div>

                    <!-- Campos de Morada -->
                    <div class="mt-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome da Morada</label>
                            <input type="text" id="name"
                                   class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                                   disabled>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                            <input type="text" id="street"
                                   class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                                   disabled>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                            <input type="text" id="city"
                                   class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                                   disabled>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                            <input type="text" id="postal_code"
                                   class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                                   disabled>
                        </div>
                    </div>
                @else
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Ainda não possui nenhuma morada.") }}
                    </p>
                @endif

                <div class="flex items-center mt-6 mb-4">
                    @if ($user->entries && $user->entries->count() > 0)
                        @foreach ($user->entries as $entry)
                            @if ($entry->survey_id == 1)
                                <a href="{{ url('entries/'.$entry->id) }}">
                                    <button type="button"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]">
                                        Ver Formulário
                                    </button>
                                </a>
                            @endif
                        @endforeach
                    @else
                        <div class="flex items-center mt-6">
                            <a href="{{ url('entries/1/fill') }}">
                                <button type="button"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]">
                                    Preencher Formulário
                                </button>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="flex justify-between items-center gap-2">
                    <a href="{{ route('setup.addressShow') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 font-semibold flex items-center text-sm mt-4 mb-5 shadow-sm w-full justify-center max-w-[100px]">
                        <i class="fa-solid fa-arrow-left w-4 h-4 mr-2"></i>
                        Voltar
                    </a>
                    <div class="flex gap-2 items-center">
                        @if(!$user->membership)
                            @if($user->entries->count() > 0 )
                                <button type="submit" id="submit-button"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]">
                                    Avançar
                                    <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                                </button>
                            @else
                                <p class="mt-1 text-sm text-red-500">
                                    {{ __("Você precisa preencher o formulário antes de adicionar um membership.") }}
                                </p>
                            @endif
                        @else
                            <a href="{{ route('setup.trainingTypesShow') }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]">
                                Avançar
                                <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                            </a>
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
            var selectedAddress = addresses.find(function (address) {
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

    // Mostrar a label de verificação se há mais de um endereço
    function checkMultipleAddresses() {
        var addresses = {!! json_encode($user->addresses) !!};
        if (addresses.length > 0) {
            document.getElementById('address-check-label').style.display = 'block';
        }
    }

    checkMultipleAddresses(); // Chama a função ao carregar a página

    // Função para permitir apenas números no campo cc_number e limitar a 9 caracteres
    document.getElementById('cc_number').addEventListener('input', function (e) {
        var value = e.target.value;
        e.target.value = value.replace(/\D/g, '').slice(0, 9);
    });

    // Função para validar o campo cc_number e mostrar/esconder a mensagem de erro no submit
    function validateForm() {
        var ccNumber = document.getElementById('cc_number') ? document.getElementById('cc_number').value : null;
        var ccNumberError = document.getElementById('cc_number_error');
        if (ccNumber && ccNumber.length === 9) {
            ccNumberError.style.display = 'none';
            return true; // Permite o envio do formulário
        } else if (ccNumber && ccNumber.length !== 9) {
            ccNumberError.style.display = 'block';
            return false; // Impede o envio do formulário
        }
        return true;
    }
</script>
