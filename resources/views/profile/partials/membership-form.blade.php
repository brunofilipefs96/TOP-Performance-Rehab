<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Matrícula') }}
        </h2>

        @if($user->membership)
            @if($user->membership->status != null)
                <div class="flex items-center mt-5">
                    <span class="mr-2">Estado:</span>
                    @if($user->membership->status->name == 'pending' || $user->membership->status->name == 'renew_pending')
                        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full" title="Pendente"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Pendente</span>
                    @elseif($user->membership->status->name == 'active')
                        <span class="inline-block w-3 h-3 bg-green-500 rounded-full" title="Ativa"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Ativa</span>
                    @elseif($user->membership->status->name == 'rejected')
                        <span class="inline-block w-3 h-3 bg-red-500 rounded-full" title="Rejeitada"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Rejeitada</span>
                    @elseif($user->membership->status->name == 'frozen')
                        <span class="inline-block w-3 h-3 bg-blue-500 rounded-full" title="Congelada"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Congelada</span>
                    @elseif($user->membership->status->name == 'pending_payment' || $user->membership->status->name == 'pending_renewPayment')
                        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full" title="Pagamento em espera"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Pagamento em espera</span>
                    @elseif($user->membership->status->name == 'awaiting_insurance')
                        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full" title="Aguarda renovação do seguro"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Aguarda renovação do seguro</span>
                    @elseif($user->membership->status->name == 'inactive')
                        <span class="inline-block w-3 h-3 bg-red-500 rounded-full" title="Inativa"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Inativa</span>
                    @elseif($user->membership->status->name == 'inactive')
                        <span class="inline-block w-3 h-3 bg-red-500 rounded-full" title="Rejeitada"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Inativa</span>
                    @endif
                </div>
            @endif

            <div class="flex items-center">
                <a href="{{ url('memberships/'.$user->membership->id) }}">
                    <button type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                        Ver Detalhes
                    </button>
                </a>
            </div>
        @else

            <div class="flex items-center mt-5">
                <span class="mr-2 text-gray-500 dark:text-gray-200">Estado:</span>
                <span class="inline-block w-3 h-3 bg-red-500 rounded-full text-gray-500 dark:text-gray-400" title="Sem Matrícula"></span>
                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Sem Matrícula</span>
            </div>

            @if($user->addresses->isEmpty())
                <div class="mt-5">
                    <span class="text-sm text-red-500 dark:text-red-400">
                        {{ __('Não existe nenhuma morada para associar. Por favor, adicione uma morada no seu perfil antes de realizar a matrícula.') }}
                    </span>
                </div>
            @else
                <div class="flex items-center mt-6">
                    <a href="{{ route('setup') }}">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                            Realizar Matrícula
                        </button>
                    </a>
                </div>
            @endif
        @endif
    </header>
</section>
