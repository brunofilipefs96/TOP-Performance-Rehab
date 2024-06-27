<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-4xl dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Referência de Pagamento</h1>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white">Pagamento Multibanco</h2>
                <p class="text-lg text-gray-800 dark:text-gray-200">Por favor, utilize as seguintes informações para completar o pagamento:</p>
                <ul class="mt-4 text-lg text-gray-800 dark:text-gray-200">
                    <li><strong>Entidade:</strong> {{ $paymentEntity }}</li>
                    <li><strong>Referência:</strong> {{ $paymentReference }}</li>
                    <li><strong>Montante:</strong> {{ number_format($amount, 2) }} €</li>
                </ul>
            </div>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Voltar ao Dashboard</a>
            </div>
        </div>
    </div>
</div>
