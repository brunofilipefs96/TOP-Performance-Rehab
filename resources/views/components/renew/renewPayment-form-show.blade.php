<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">1</span>
                    <span class="text text-gray-900 dark:text-white">Matrícula</span>
                    <span class="spacer"></span>
                </span>
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">2</span>
                    <span class="text text-gray-900 dark:text-white">Seguro</span>
                    <span class="spacer"></span>
                </span>
                <span class="step active">
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
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Pagamento</h1>
            </div>
            <form id="payment-form" action="{{ route('renew.processRenew') }}" method="POST" onsubmit="disableConfirmButton(this)">
                @csrf

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
                @if($user->membership->insurance->status->name == 'pending_renewPayment' && $user->membership->insurance->insurance_type == 'Ginásio')
                    <p class="mb-4">Taxa de Inscrição: {{ setting('taxa_inscricao') }}€</p>
                    <p class="mb-4">Taxa de Seguro: {{ setting('taxa_seguro') }}€</p>
                    <p class="mb-4">Total: {{ setting('taxa_inscricao') + setting('taxa_seguro') }}€</p>
                @else
                    <p class="mb-4">Taxa de Inscrição: {{ setting('taxa_inscricao') }}€</p>
                    <p class="mb-4">Total: {{ setting('taxa_inscricao') }}€</p>
                @endif

                <div class="flex justify-end mt-6">
                    <button type="submit" id="payment-button" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">Finalizar Compra</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('payment-form').addEventListener('submit', function (e) {
        const paymentButton = document.getElementById('payment-button');
        paymentButton.disabled = true;
        paymentButton.innerHTML = 'Processando...';
    });
</script>
