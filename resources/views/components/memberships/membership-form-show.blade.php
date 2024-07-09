<div class="container mx-auto mt-5 pt-5 glass">
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

                    <div class="mb-4">
                        <label for="address_postal_code" class="block text-gray-900 dark:text-gray-200">Código-Postal</label>
                        <input type="text" id="address_postal_code" value="{{ $membership->address->postal_code }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                    </div>

                    <div class="flex items-center mt-6 mb-4">
                        @foreach ($membership->user->entries as $entry)
                            @if ($entry->survey_id == 1)
                                <a href="{{ url('entries/'.$entry->id) }}">
                                    <button type="button"
                                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                                        Ver Formulário
                                    </button>
                                </a>
                            @endif
                        @endforeach
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
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Ativo</p>
                            <span class="h-3 w-3 bg-green-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'pending')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Pendente</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'rejected')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Rejeitado</p>
                            <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'frozen')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Congelado</p>
                            <span class="h-3 w-3 bg-blue-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'pending_payment')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Pagamento em espera</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @endif
                    </div>

                    @if($membership->status->name == 'active')
                        {{-- Active --}}
                        <div class="mb-4">
                            <label for="total_trainings_supervised" class="block text-gray-900 dark:text-gray-200">Treinos disponíveis com Personal
                                Trainer</label>
                            <input type="text" value="{{ $membership->total_trainings_supervised }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="total_trainings_individual" class="block text-gray-900 dark:text-gray-200">Treinos disponíveis
                                Individuais</label>
                            <input type="text" value="{{ $membership->total_trainings_individual }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>
                    @endif
                    <div class="flex justify-end mb-2">
                        @can('update' , $membership)
                            @if($membership->status->name == 'pending' || $membership->status->name == 'frozen')
                                {{-- Pending --}}
                                <div class="flex justify-center">
                                    <form
                                        action="{{ route('memberships.update', ['membership' => $membership->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_name" value="pending_payment">
                                        <button type="submit"
                                                class="inline-block bg-green-500 mt-4 mr-1 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                            Aceitar
                                        </button>
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
                            @if($membership->status->name == 'active' || $membership->status->name == 'pending')
                                <div class="flex items-center">
                                    @if($membership->status->name == 'active')
                                        <a href="{{ route('memberships.evaluations.list', ['membership' => $membership->id]) }}"
                                           class="inline-block border-tg dark:hover:bg-lime-300 bg-blue-500 dark:text-lime-800 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 text-white">
                                            Avaliações
                                        </a>
                                    @endif
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
