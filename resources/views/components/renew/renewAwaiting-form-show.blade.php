<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps-custom">
            <span class="step-custom complete-custom">
                <span class="number-custom text-gray-900 dark:text-white">1</span>
                <span class="text-custom text-gray-900 dark:text-white">Matrícula</span>
                <span class="spacer-custom"></span>
            </span>
                <span class="step-custom active-custom">
                <span class="number-custom text-gray-900 dark:text-white">2</span>
                <span class="text-custom text-gray-900 dark:text-white">Seguro</span>
                <span class="spacer-custom half-custom relative">
                    <span class="half-filled-custom"></span>
                    <span class="icon-wrapper-custom absolute">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </span>
                </span>
            </span>
                <span class="step-custom">
                <span class="number-custom text-gray-900 dark:text-white">3</span>
                <span class="text-custom text-gray-900 dark:text-white">Pagamento</span>
                <span class="spacer-custom"></span>
            </span>
            </div>
        </div>
    </div>
    </div>
    <div class="flex justify-center mt-8">
        <div class="w-full max-w-2xl bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-5 rounded-lg shadow-md">
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Processo de Avaliação</h1>
            </div>
            <div class="flex items-center mb-2">
                @if($user->membership->status->name == 'awaiting_insurance')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Matrícula: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Pendente do Seguro</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->status->name == 'renew_pending')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Matrícula: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Em Avaliação</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->status->name == 'pending_renewPayment')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Matrícula: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Aguarda Pagamento</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->status->name == 'rejected')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Matrícula: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Rejeitada</p>
                    <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                @endif
            </div>
            <div class="flex items-center mb-2">
                @if($user->membership->insurance->status->name == 'awaiting_insurance')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado do Seguro: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Pendente da Matrícula</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->insurance->status->name == 'renew_pending')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Seguro: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Em Avaliação</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->insurance->status->name == 'pending_renewPayment')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Seguro: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Aguarda Pagamento</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->insurance->status->name == 'rejected')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Seguro: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Rejeitada</p>
                    <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                @endif
            </div>

            @if($user->membership->status->name == 'renew_pending' &&  $user->membership->insurance->status->name == 'renew_pending')
                <p class="text-center text-lg mt-4">
                    Por favor, aguarde enquanto a sua matrícula e seguro são avaliados pelo administrador.
                </p>
                <p class="text-center text-lg">
                    Será notificado assim que a avaliação for concluída.
                </p>
            @elseif(($user->membership->status->name == 'pending_renewPayment' && ($user->membership->insurance->status->name == 'pending_renewPayment')) || ($user->membership->status->name == 'pending_renewPayment' && ($user->membership->insurance->status->name == 'awaiting_membership')) || ($user->membership->status->name == 'awaiting_insurance' && ($user->membership->insurance->status->name == 'pending_renewPayment')))
                <p class="text-center text-lg mt-4">
                    Os seus dados foram avaliados e aceites.
                </p>
                <p class="text-center text-lg">
                    Por favor, prossiga com o pagamento.
                </p>
                <div class="flex justify-between items-center mt-6 gap-2">
                    <a href="{{ route('renew.renewInsurance') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 font-semibold flex items-center text-sm shadow-sm">
                        <i class="fa-solid fa-arrow-left w-4 h-4 mr-2"></i>
                        Voltar
                    </a>
                    <a href="{{ route('renew.renewPayment') }}"
                       class="ml-auto bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm">
                        Avançar
                        <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                    </a>
                </div>
            @elseif($user->membership->status->name == 'pending_renewPayment' || $user->membership->insurance->status->name == 'pending_renewPayment')
                <p class="text-center text-lg mt-4">
                    Por favor, aguarde enquanto os seus dados estão a ser avaliados pelo administrador.
                </p>
                <p class="text-center text-lg">
                    Será notificado assim que a avaliação for concluída.
                </p>
            @elseif($user->membership->status->name == 'rejected' || $user->membership->insurance->status->name == 'rejected')
                <p class="text-center text-lg mt-4">
                    Infelizmente, os seus dados foram rejeitados.
                </p>
                <p class="text-center text-lg">
                    Por favor, entre em contacto com o administrador para mais informações.
                </p>
                <p class="text-center text-lg mt-4">Telemóvel: {{setting('telemovel', '910000000')}}, Email: {{setting('email', 'ginasiotop@email.pt')}}</p>
            @endif
        </div>
    </div>
</div>

<style>
    .progress-steps-custom {
        align-items: center;
        display: flex;
        opacity: 1;
        position: relative;
        top: 0;
        transition: .2s;
        visibility: visible;
    }

    .step-custom {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        flex: 1;
    }

    .number-custom {
        background-color: #3d3d3d;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 2.5rem;
        width: 2.5rem;
    }

    .text-custom {
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }

    .spacer-custom {
        position: absolute;
        top: 1.25rem;
        left: calc(50% + 1.25rem);
        height: 4px;
        width: calc(100% - 2.5rem);
        background-color: #3d3d3d;
    }

    .step-custom:last-child .spacer-custom {
        display: none;
    }

    .step-custom.active-custom .number-custom {
        background-color: #ff5400;
    }

    .step-custom.complete-custom .number-custom,
    .step-custom.complete-custom .spacer-custom {
        background-color: #ff5400;
    }

    .step-custom .text-custom.last {
        padding-right: 1rem;
    }

    .spacer-custom.half-custom {
        width: calc(100% - 2.5rem);
        display: flex;
    }

    .spacer-custom.half-custom .half-filled-custom {
        width: 48%;
        background-color: #ff5400;
    }

    .spacer-custom.half-custom::after {
        content: '';
        width: 52%;
        background-color: gray;
    }

    .icon-wrapper-custom {
        position: absolute;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 35px;
        color: #ff5400;
        z-index: 10;
    }

    .dark .step-custom .number-custom {
        background-color: #3d3d3d;
    }

    .dark .step-custom.complete-custom .number-custom,
    .dark .step-custom.complete-custom .spacer-custom,
    .dark .step-custom.active-custom .number-custom {
        background-color: #84cc16;
    }

    .dark .spacer-custom.half-custom .half-filled-custom {
        background-color: #84cc16;
    }

    .dark .spacer-custom.half-custom::after {
        background-color: #3d3d3d;
    }

    .step-custom .number-custom {
        background-color: #555555;
    }

    .step-custom.complete-custom .number-custom,
    .step-custom.complete-custom .spacer-custom,
    .step-custom.active-custom .number-custom {
        background-color: #3b82f6;
    }

    .spacer-custom.half-custom .half-filled-custom {
        background-color: #3b82f6;
    }

    .spacer-custom.half-custom::after {
        background-color: gray;
    }
</style>

