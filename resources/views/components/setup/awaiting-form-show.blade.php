<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps relative">
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">1</span>
                    <span class="text text-gray-900 dark:text-white">Morada</span>
                    <span class="spacer"></span>
                </span>
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">2</span>
                    <span class="text text-gray-900 dark:text-white">Matrícula</span>
                    <span class="spacer"></span>
                </span>
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">3</span>
                    <span class="text text-gray-900 dark:text-white">Modalidades</span>
                    <span class="spacer"></span>
                </span>
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">4</span>
                    <span class="text text-gray-900 dark:text-white">Seguro</span>
                    <span class="spacer half relative">
                        <span class="half-filled"></span>
                        <span class="icon-wrapper absolute">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </span>
                    </span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">5</span>
                    <span class="text last text-gray-900 dark:text-white">Pagamento</span>
                </span>
            </div>
        </div>
    </div>
    <div class="flex justify-center mt-8">
        <div class="w-full max-w-2xl bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-5 rounded-lg shadow-md">
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Processo de Avaliação</h1>
            </div>
            <div class="flex items-center mb-2">
                @if($user->membership->status->name == 'pending')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Matricula: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Em avaliação</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->status->name == 'pending_payment')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Matricula: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Pagamento em Espera</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->status->name == 'rejected')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado da Matricula: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Rejeitada</p>
                    <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                @endif
            </div>
            <div class="flex items-center mb-2">
                @if($user->membership->insurance->status->name == 'pending')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado do Seguro: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Em avaliação</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->insurance->status->name == 'pending_payment')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado do Seguro: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Pagamento em espera</p>
                    <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                @elseif($user->membership->insurance->status->name == 'rejected')
                    <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado do Seguro: </p>
                    <p class="dark:text-gray-400 text-gray-700 mr-2 align-middle">Rejeitada</p>
                    <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                @endif
            </div>

            @if($user->membership->status->name == 'pending' &&  $user->membership->insurance->status->name == 'pending')
                <p class="text-center text-lg mt-4">
                    Por favor, aguarde enquanto a sua matrícula e seguro são avaliados pelo administrador.
                </p>
                <p class="text-center text-lg">
                    Será notificado assim que a avaliação for concluída.
                </p>
            @elseif($user->membership->status->name == 'pending_payment' && ($user->membership->insurance->status->name == 'pending_payment' || $user->membership->insurance->status->name == 'active'))
                <p class="text-center text-lg mt-4">
                    Os seus dados foram avaliados e aceites.
                </p>
                <p class="text-center text-lg">
                    Por favor, prossiga com o pagamento.
                </p>
                <div class="flex justify-between items-center mt-6 gap-2">
                    <a href="{{ route('setup.insuranceShow') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 font-semibold flex items-center text-sm shadow-sm">
                        <i class="fa-solid fa-arrow-left w-4 h-4 mr-2"></i>
                        Voltar
                    </a>
                    <a href="{{ route('setup.paymentShow') }}"
                       class="ml-auto bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm">
                        Avançar
                        <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                    </a>
                </div>
            @elseif($user->membership->status->name == 'pending_payment' || $user->membership->insurance->status->name == 'pending_payment')
                <p class="text-center text-lg mt-4">
                    Por favor, aguarde enquanto os deus dados estão a ser avaliados pelo administrador.
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
    .message-box {
        background-color: #f8f9fa;
        color: #212529;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        text-align: center;
        font-size: 1.125rem;
    }

    .dark .message-box {
        background-color: #343a40;
        color: #f8f9fa;
    }
</style>
