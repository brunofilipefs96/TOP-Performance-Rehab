<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div class="flex justify-center">
                <div class="w-full max-w-lg">

                    <div>
                        <h1 class="mb-6 mt-2 text-2xl dark:text-lime-400 text-gray-900">Seguro {{ $insurance->id }}</h1>
                    </div>

                    <div class="mb-4">
                        <label for="user_name" class="block text-gray-900 dark:text-gray-200">Nome do Utilizador</label>
                        <input type="text" value="{{ $insurance->membership->user->full_name }}" disabled
                               class="mt-1 block w-full p-2 border dark:border-gray-500 border-white text-gray-800  dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div class="mb-4">
                        <label for="nif" class="block text-gray-900 dark:text-gray-200">Número Identificação Fiscal</label>
                        <input type="text" value="{{ $insurance->membership->user->nif }}" disabled
                               class="mt-1 block w-full p-2 border dark:border-gray-500 border-white text-gray-800  dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div>
                        <h1 class="mb-2 text-xl text-gray-900 dark:text-gray-200">Dados do Seguro</h1>
                    </div>

                    <div class="mb-4">
                        <label for="insurance_insurance_type" class="block text-gray-900 dark:text-gray-200">Tipo de Seguro</label>
                        <input type="text" id="insurance_insurance_type"
                               value="{{ $insurance->insurance_type }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800  dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-900 dark:text-gray-200">Data de Início</label>
                        <input type="text" id="start_date"
                               value="{{ \Carbon\Carbon::parse($insurance->start_date)->format('d/m/Y') }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800  dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-900 dark:text-gray-200">Data de Fim</label>
                        <input type="text" id="end_date"
                               value="{{ \Carbon\Carbon::parse($insurance->end_date)->format('d/m/Y') }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800  dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div class="flex items-center mb-2">
                        @if($insurance->status->name == 'active')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Ativo</p>
                            <span class="h-3 w-3 bg-green-500 rounded-full inline-block"></span>
                        @elseif($insurance->status->name == 'pending')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Pendente</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @elseif($insurance->status->name == 'rejected')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Rejeitado</p>
                            <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                        @elseif($insurance->status->name == 'frozen')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Congelado</p>
                            <span class="h-3 w-3 bg-blue-500 rounded-full inline-block"></span>
                        @endif
                    </div>

                    <div class="flex justify-end mb-2">
                        @can('update', $insurance)
                            @if($insurance->status->name == 'pending' || $insurance->status->name == 'frozen')
                                <div class="flex justify-center">
                                    <form
                                        action="{{ route('insurances.update', ['insurance' => $insurance->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_name" value="active">
                                        <button type="submit"
                                                class="inline-block bg-green-500 mt-4 mr-1 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                            Ativar
                                        </button>
                                    </form>
                                    <form
                                        action="{{ route('insurances.update', ['insurance' => $insurance->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_name" value="rejected">
                                        <button type="submit"
                                                class="inline-block bg-red-500 mt-4 py-2 px-5 rounded-md shadow-sm hover:bg-red-700 text-white">
                                            Rejeitar
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if($insurance->status->name == 'active' || $insurance->status->name == 'pending')
                                <form
                                    action="{{ route('insurances.update', ['insurance' => $insurance->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_name" value="frozen">
                                    <button type="submit"
                                            class="inline-block bg-blue-500 ml-1 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-blue-700 text-white">
                                        Congelar
                                    </button>
                                </form>
                            @endif
                        @endcan
                        <div class="flex justify-end">
                            @if(Auth::user()->hasRole('admin'))
                                <a href="{{ route('insurances.index') }}"
                                   class="inline-block bg-gray-500 ml-1 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-gray-700 text-white">
                                    Voltar
                                </a>
                            @else
                                <a href="{{ route('profile.edit') }}"
                                   class="inline-block bg-gray-500 ml-1 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-gray-700 text-white">
                                    Voltar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
