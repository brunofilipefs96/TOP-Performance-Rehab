<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Vendas</h1>
    <hr class="mb-10 border-gray-400 dark:border-gray-300">

    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
            <thead>
            <tr>
                <th class="p-4 text-left">ID</th>
                <th class="p-4 text-left">Utilizador</th>
                <th class="p-4 text-left">Morada</th>
                <th class="p-4 text-left">Estado</th>
                <th class="p-4 text-left">Total</th>
                <th class="p-4 text-left">Método de Pagamento</th>
                <th class="p-4 text-left">Data</th>
                <th class="p-4 text-left">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td class="p-4">{{ $sale->id }}</td>
                    <td class="p-4">{{ $sale->user->firstLastName() }}</td>
                    <td class="p-4">{{ $sale->address->street }}, {{ $sale->address->city }}, {{ $sale->address->postal_code }}</td>
                    <td class="p-4">{{ $sale->status->name }}</td>
                    <td class="p-4">{{ number_format($sale->total, 2) }} €</td>
                    <td class="p-4">{{ $sale->payment_method }}</td>
                    <td class="p-4">{{ $sale->created_at }}</td>
                    <td class="p-4">
                        <a href="{{ route('sales.show', $sale->id) }}"
                           class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-400">Ver</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
