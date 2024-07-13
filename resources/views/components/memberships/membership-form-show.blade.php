<div class="container mx-auto mt-5 pt-5 glass">
    @php
        $user = auth()->user();
    @endphp
    @if($user->hasRole('client') && ($user->membership && ($user->membership->status->name == 'inactive' && $user->membership->insurance->status->name == 'inactive')))
        <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
            <p class="font-bold">A sua matrícula e o seu seguro expiraram! </p>
            <p>Se deseja renovar a sua matrícula e o seguro, clique no botão abaixo para renovar!</p>
            <a href="{{ route('renew') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Renovar Dados</a>
        </div>
    @elseif($user->hasRole('client') && ($user->membership && $user->membership->status->name == 'inactive'))
        <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
            <p class="font-bold">A sua matrícula expirou! </p>
            <p>Se deseja renovar a sua matrícula, clique no botão abaixo para renovar!</p>
            <a href="{{ route('renew') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Renovar Dados</a>
        </div>
    @elseif($user->hasRole('client') && ($user->membership && $user->membership->insurance->status->name == 'inactive'))
        <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
            <p class="font-bold">O seu seguro expirou! </p>
            <p>Se deseja renovar o seu seguro, clique no botão abaixo para renovar!</p>
            <a href="{{ route('renew') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Renovar Dados</a>
        </div>
    @elseif($user->hasRole('client') && ($user->membership && $user->membership->status->name == 'awaiting_insurance'))
        <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
            <p class="font-bold">A sua matrícula está aguardando pelo seguro!</p>
            <p>Por favor, complete o processo de seguro para continuar.</p>
            <a href="{{ route('renew') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Renovar Dados</a>
        </div>
    @elseif($user->hasRole('client') && ($user->membership && $user->membership->status->name == 'awaiting_membership'))
        <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
            <p class="font-bold">A sua inscrição está pendente de aprovação!</p>
            <p>Aguarde até que a sua inscrição seja aprovada.</p>
            <a href="{{ route('renew') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Renovar Dados</a>
        </div>
    @elseif($user->hasRole('client') && ($user->membership && $user->membership->status->name == 'renew_pending'))
        <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
            <p class="font-bold">A renovação da sua matrícula está pendente!</p>
            <p>Aguarde até que o processo de renovação seja concluído.</p>
            <a href="{{ route('renew') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Renovar Dados</a>
        </div>
    @elseif($user->hasRole('client') && ($user->membership && $user->membership->status->name == 'pending_renewPayment'))
        <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
            <p class="font-bold">O pagamento da renovação está pendente!</p>
            <p>Por favor, complete o pagamento para concluir a renovação.</p>
            <a href="{{ route('renew') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Renovar Dados</a>
        </div>
    @endif
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div class="flex justify-center">
                <div class="w-full max-w-lg">
                    <div>
                        <h1 class="mb-6 mt-2 text-2xl text-gray-900 dark:text-lime-400">Matrícula {{ $membership->id }}</h1>
                    </div>

                    <div class="mb-4">
                        <label for="user_name" class="block text-gray-900 dark:text-gray-200">Nome do Utilizador</label>
                        <input type="text" value="{{ $membership->user->full_name }}" disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="nif" class="block text-gray-900 dark:text-gray-200">Número Identificação Fiscal</label>
                        <input type="text" value="{{ $membership->user->nif }}" disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="cc_number" class="block text-gray-900 dark:text-gray-200">Número Contribuinte</label>
                        <input type="text" value="{{ $membership->user->cc_number }}" disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                    </div>

                    <div class="mb-8">
                        <label for="birth_date" class="block text-gray-900 dark:text-gray-200">Data Nascimento</label>
                        <input type="text"
                               value="{{ \Carbon\Carbon::parse($membership->user->birth_date)->format('d/m/Y') }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                    </div>

                    <div>
                        <h1 class="mb-2 text-xl text-gray-900 dark:text-gray-200">Morada</h1>
                    </div>

                    <div class="mb-4">
                        <label for="address_name" class="block text-gray-900 dark:text-gray-200">Nome</label>
                        <input type="text" value="{{ $membership->address->name }}" disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_street" class="block text-gray-900 dark:text-gray-200">Nome da Rua</label>
                        <input type="text" value="{{ $membership->address->street }}" disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_city" class="block text-gray-900 dark:text-gray-200">Cidade</label>
                        <input type="text" value="{{ $membership->address->city }}" disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                    </div>

                    <div class="mb-5">
                        <label for="address_postal_code" class="block text-gray-900 dark:text-gray-200">Código-Postal</label>
                        <input type="text" id="address_postal_code" value="{{ $membership->address->postal_code }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                    </div>

                    <div>
                        <h1 class="mb-2 text-2xl text-gray-900 dark:text-gray-200">Documentos</h1>
                    </div>

                    <div class="flex items-center mt-1 mb-6">
                        @foreach ($membership->user->entries as $entry)
                            @if ($entry->survey_id == 1)
                                <a href="{{ url('entries/'.$entry->id) }}">
                                    <button type="button"
                                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                                        Ficha de Anamnese
                                    </button>
                                </a>
                            @endif
                        @endforeach
                        <a href="{{ url('insurances/'.$membership->insurance->id) }}" class="pl-2">
                            <button type="button"
                                    class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                                Seguro
                            </button>
                        </a>
                    </div>

                    <!-- New section for questions and answers -->
                    <div class="mb-4">
                        <h2 class="mb-2 text-xl text-gray-900 dark:text-gray-200">Observações</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                @foreach ($membership->user->entries as $entry)
                                    @foreach ($entry->answers as $answer)
                                        @if($answer->question_id >= 14 && $answer->question_id <= 18 && $answer->value != 'Nenhum')
                                            @foreach(explode(', ', $answer->value) as $individualAnswer)
                                                <div class="flex items-center">
                                                    <span class="h-2 w-2 rounded-full inline-block mr-2 bg-gray-900 dark:bg-gray-200"></span>
                                                    <label class="block text-gray-900 dark:text-gray-200">{{ $individualAnswer }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                            <div>
                                @foreach ($membership->user->entries as $entry)
                                    @foreach ($entry->answers as $answer)
                                        @if($answer->question_id >= 19 && $answer->question_id <= 22 && $answer->value != 'Nenhum')
                                            @foreach(explode(', ', $answer->value) as $individualAnswer)
                                                <div class="flex items-center">
                                                    <span class="h-2 w-2 rounded-full inline-block mr-2 bg-gray-900 dark:bg-gray-200"></span>
                                                    <label class="block text-gray-900 dark:text-gray-200">{{ $individualAnswer }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center mb-2">
                        @if($membership->status->name == 'active')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Ativa</p>
                            <span class="h-3 w-3 bg-green-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'pending' || $membership->status->name == 'renew_pending')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Pendente</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'rejected')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Rejeitado</p>
                            <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'frozen')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Congelada</p>
                            <span class="h-3 w-3 bg-blue-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'pending_payment' || $membership->status->name == 'pending_renewPayment')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Pagamento em espera</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'inactive')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Inativa</p>
                            <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'awaiting_insurance')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Aguarda renovação do seguro</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @endif
                    </div>
                    @if($membership->status->name == 'active')
                        {{-- Active --}}
                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-900 dark:text-gray-200">Data de Início</label>
                            <input type="text" id="start_date"
                                   value="{{ \Carbon\Carbon::parse($membership->start_date)->format('d/m/Y') }}"
                                   disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                        </div>
                        <div class="mb-4">
                            <label for="end_date" class="block text-gray-900 dark:text-gray-200">Data de Fim</label>
                            <input type="text" id="end_date"
                                   value="{{ \Carbon\Carbon::parse($membership->end_date)->format('d/m/Y') }}"
                                   disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                        </div>
                    @endif

                    <div class="flex justify-end mb-2">
                        @if($membership->status->name == 'active')
                            <a href="{{ route('memberships.evaluations.list', ['membership' => $membership->id]) }}"
                               class="inline-block border-tg dark:hover:bg-lime-300 bg-blue-500 dark:text-lime-800 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 text-white">
                                Avaliações
                            </a>
                        @endif
                        @can('update' , $membership)
                            @if($membership->status->name == 'pending' || $membership->status->name == 'frozen' || $membership->status->name == 'renew_pending')
                                {{-- Pending --}}
                                <div class="flex justify-center">
                                    <form
                                        action="{{ route('memberships.update', ['membership' => $membership->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if($membership->status->name == 'pending')
                                        <input type="hidden" name="status_name" value="pending_payment">
                                        <button type="submit"
                                                class="inline-block bg-green-500 mt-4 mr-1 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                            Aceitar
                                        </button>
                                        @elseif($membership->status->name == 'renew_pending')
                                            <input type="hidden" name="status_name" value="pending_renewPayment">
                                            <button type="submit"
                                                    class="inline-block bg-green-500 mt-4 mr-1 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                                Aceitar
                                            </button>
                                        @endif
                                    </form>
                                    <form
                                        action="{{ route('memberships.update', ['membership' => $membership->id]) }}"
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
                            @if($membership->status->name == 'active' || $membership->status->name == 'pending' || $membership->status->name == 'renew_pending')
                                <div class="flex items-center">
                                    <form
                                        action="{{ route('memberships.update', ['membership' => $membership->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_name" value="frozen">
                                        <button type="submit"
                                                class="inline-block bg-blue-500 ml-1 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-blue-700 text-white">
                                            Congelar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endcan
                        <div class="flex justify-end">
                            @if(Auth::user()->hasRole('admin'))
                                <a href="{{ route('memberships.index') }}"
                                   class="inline-block bg-gray-500 ml-1 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-gray-700 text-white">
                                    Voltar
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
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
