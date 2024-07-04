<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Seguro') }}
        </h2>


        @if($user->membership)
            @if($user->membership->insurance)
                <div class="flex items-center mt-5">
                    <span class="mr-2">Estado:</span>
                    @if($user->membership->insurance->status->name == 'pending')
                        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full" title="Pendente"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Pendente</span>
                    @elseif($user->membership->insurance->status->name == 'active')
                        <span class="inline-block w-3 h-3 bg-green-500 rounded-full" title="Ativo"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Ativo</span>
                    @elseif($user->membership->insurance->status->name == 'inactive')
                        <span class="inline-block w-3 h-3 bg-red-500 rounded-full" title="Inativo"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Inativo</span>
                    @elseif($user->membership->insurance->status->name == 'pending_payment')
                        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full" title="Pagamento em espera"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Pagamento em espera</span>
                    @endif
                </div>
                <div class="flex items-center">
                    <a href="{{ url('insurances/'.$user->membership->insurance->id) }}">
                        <button type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                            Ver Detalhes
                        </button>
                    </a>
                </div>
                @else
                <div class="flex items-center mt-5">
                    <span class="mr-2 text-gray-500 dark:text-gray-200">Estado:</span>
                    <span class="inline-block w-3 h-3 bg-red-500 rounded-full text-gray-500 dark:text-gray-400" title="Sem Seguro"></span>
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Sem Seguro</span>
                </div>
                <div class="flex items-center mt-6">
                    <a href="{{ route('setup') }}">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                            Adicionar Seguro
                        </button>
                    </a>
                </div>

            @endif
        @else
            <div class="flex items-center mt-5">
                <span class="mr-2 text-gray-500 dark:text-gray-200">Estado:</span>
                <span class="inline-block w-3 h-3 bg-red-500 rounded-full text-gray-500 dark:text-gray-400" title="Sem Seguro"></span>
                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Sem Seguro</span>
            </div>
            <div class="mt-5">
                    <span class="text-sm text-red-500 dark:text-red-400">
                        {{ __('Não existe nenhuma matrícula para associar. Por favor, adicione uma matrícula no seu perfil antes de adicionar o seguro.') }}
                    </span>
            </div>
        @endif
    </header>

    @if(session('address_added'))
        <div class="mt-5">
            <span class="text-sm text-green-500 dark:text-green-400">
                {{ session('address_added') }} {{ __('Agora você pode realizar a matrícula.') }}
            </span>
        </div>
    @endif
</section>
