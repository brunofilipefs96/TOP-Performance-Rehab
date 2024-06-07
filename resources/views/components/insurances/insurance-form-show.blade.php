<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div class="flex justify-center">
                <div class="w-full max-w-lg">

                    <div>
                        <h1 class="mb-6 mt-2 text-2xl">Seguro {{ $insurance->id }}</h1>
                    </div>

                    <div class="mb-4">
                        <label for="user_name" class="block">Nome do Utilizador</label>
                        <input type="text" value="{{ $insurance->membership->user->full_name }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="nif" class="block">Número Identificação Fiscal</label>
                        <input type="text" value="{{ $insurance->membership->user->nif }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="cc_number" class="block">Número Contribuinte</label>
                        <input type="text" value="{{ $insurance->membership->user->cc_number }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div>
                        <h1 class="mb-2 text-xl">Morada</h1>
                    </div>

                    <div class="mb-4">
                        <label for="address_name" class="block">Nome</label>
                        <input type="text" value="{{ $insurance->membership->address->name }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_street" class="block">Nome da Rua</label>
                        <input type="text" value="{{ $insurance->membership->address->street }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_city" class="block">Cidade</label>
                        <input type="text" value="{{ $insurance->membership->address->city }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_postal_code" class="block">Código-Postal</label>
                        <input type="text" id="address_postal_code"
                               value="{{ $insurance->membership->address->postal_code }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div>
                        <h1 class="mb-2 text-xl">Dados do Seguro</h1>
                    </div>

                    <div class="mb-4">
                        <label for="insurance_insurance_type" class="block">Tipo de Seguro</label>
                        <input type="text" id="insurance_insurance_type"
                               value="{{ $insurance->insurance_type }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block">Data de Início</label>
                        <input type="text" id="start_date"
                               value="{{ \Carbon\Carbon::parse($insurance->start_date)->format('d/m/Y') }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block">Data de Fim</label>
                        <input type="text" id="end_date"
                               value="{{ \Carbon\Carbon::parse($insurance->end_date)->format('d/m/Y') }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="flex justify-end mb-2">
                        @if($insurance->status == 'pending')
                            <div class="flex justify-center">
                                <form
                                    action="{{ route('insurances.updateStatus', ['insurance' => $insurance->id, 'status' => 'active']) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="inline-block bg-green-500 mt-4 mr-1 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                        Ativar
                                    </button>
                                </form>
                                <form
                                    action="{{ route('insurances.updateStatus', ['insurance' => $insurance->id, 'status' => 'inactive']) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="inline-block bg-red-500 mt-4 py-2 px-5 rounded-md shadow-sm hover:bg-red-700 text-white">
                                        Rejeitar
                                    </button>
                                    <a href="{{ route('insurances.index') }}"
                                       class="inline-block bg-gray-500 py-2 px-6 rounded-md shadow-sm hover:bg-gray-700 text-white">
                                        Voltar
                                    </a>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('insurances.index') }}"
                               class="inline-block bg-gray-500 py-2 px-6 rounded-md shadow-sm hover:bg-gray-700 text-white">
                                Voltar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
