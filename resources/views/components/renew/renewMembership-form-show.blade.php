<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
                <span class="step active">
                    <span class="number text-gray-900 dark:text-white">1</span>
                    <span class="text text-gray-900 dark:text-white">Matrícula</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">2</span>
                    <span class="text text-gray-900 dark:text-white">Seguro</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">3</span>
                    <span class="text text-gray-900 dark:text-white">Pagamento</span>
                    <span class="spacer"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-2xl bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Renovar Membership</h1>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-800 dark:text-white">Nome</label>
                <input type="text" value="{{ Auth::user()->full_name }}" disabled
                       class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <!-- Citizen Card Number Field -->
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
                    {{ __('Morada') }}
                </h2>
            </header>
            <div class="mt-3">
                <div class="mb-4">
                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Nome da Morada</label>
                    <input type="text" id="name" value="{{ $user->membership->address->name }}"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                           disabled>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Rua</label>
                    <input type="text" id="street" value="{{ $user->membership->address->street }}"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                           disabled>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Cidade</label>
                    <input type="text" id="city" value="{{ $user->membership->address->city }}"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                           disabled>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Código Postal</label>
                    <input type="text" id="postal_code" value="{{ $user->membership->address->postal_code }}"
                           class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                           disabled>
                </div>
            </div>

            <form method="POST" action="{{ route('renew.updateMembership', $user->membership) }}" enctype="multipart/form-data" onsubmit="disableConfirmButton(this)">
                @csrf
                @method('POST')
                <input type="hidden" name="address_id" id="address_id">
                <div class="flex justify-between items-center gap-2">
                    <a href="{{ route('dashboard') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 font-semibold flex items-center text-sm mt-4 mb-5 shadow-sm w-full justify-center max-w-[100px]">
                        <i class="fa-solid fa-arrow-left w-4 h-4 mr-2"></i>
                        Voltar
                    </a>
                    <div class="flex gap-2 items-center">
                        @if($user->membership && $user->membership->status->name == 'inactive')
                            <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]">
                                Renovar
                                <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                            </button>
                        @elseif($user->membership && $user->membership->status->name != 'inactive')
                            <a href="{{ route('renew.renewInsurance') }}"
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
    document.getElementById('cc_number').addEventListener('input', function (e) {
        var value = e.target.value;
        e.target.value = value.replace(/\D/g, '').slice(0, 9);
    });

    function validateForm() {
        var ccNumber = document.getElementById('cc_number') ? document.getElementById('cc_number').value : null;
        var ccNumberError = document.getElementById('cc_number_error');
        if (ccNumber && ccNumber.length === 9) {
            ccNumberError.style.display = 'none';
            return true;
        } else if (ccNumber && ccNumber.length !== 9) {
            ccNumberError.style.display = 'block';
            return false;
        }
        return true;
    }
</script>
