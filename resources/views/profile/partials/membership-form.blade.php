<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Matrícula') }}
        </h2>

        @if($user->membership)
            @if($user->membership->status)
                <div class="flex items-center mt-5">
                    <span class="mr-2">Estado:</span>
                    @if($user->membership->status == 'pending')
                        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full" title="Pendente"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Pendente</span>
                    @elseif($user->membership->status == 'active')
                        <span class="inline-block w-3 h-3 bg-green-500 rounded-full" title="Ativa"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Ativa</span>
                    @elseif($user->membership->status == 'denied')
                        <span class="inline-block w-3 h-3 bg-red-500 rounded-full" title="Recusada"></span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Recusada</span>
                    @endif
                </div>
            @endif

            <div class="flex items-center">
                <a href="{{ url('users/'.$user->id.'/membership/show') }}">
                    <button type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                        Ver Detalhes
                    </button>
                </a>
            </div>
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Ainda não possui Matrícula.') }}
            </p>

            <div class="flex items-center">
                <button type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150" onclick="createMembership()">
                    Realizar Matrícula
                </button>
            </div>
        @endif

        <div id="create-membership-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
            <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Matricula</h2>
                <form id="createMembershipForm" method="POST" action="{{ route('profile.membership.store') }}" class="mt-2 space-y-6">
                    @csrf
                    @if($user->addresses && $user->addresses->count() > 0)
                        <div>
                            <x-input-label for="address_id" :value="__('Selecione uma morada')" class="mt-5 mb-1"/>
                            <select id="address_id" name="address_id" class="w-1/2 dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 dark:text-gray-900 focus:border-lime-500 dark:focus:border-lime-600 focus:ring-lime-500 dark:focus:ring-lime-600 rounded-md shadow-sm">
                                @foreach($user->addresses as $address)
                                    <option value="{{ $address->id }}" @if($loop->first) selected @endif>{{ $address->name }}</option>
                                @endforeach
                            </select>
                            @error('address_id')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    @else
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Morada</label>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Necessita de inserir uma morada para se matrícular. Pode inserir a morada no seu perfil.') }}
                        </p>
                    @endif

                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Ficha de Anamnese</label>
                    @if($user->membershipEntry())
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Já preencheu a Ficha de Anamnese.') }}
                        </p>
                        <a href="{{ url('profile/entries/1') }}">
                            <button type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150 ">Verificar Respostas</button>
                        </a>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Necessita de preencher a Ficha de Anamnese.') }}
                        </p>
                        <a href="{{ url('entries/1/fill') }}">
                            <button type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">Preencher Ficha</button>
                        </a>
                    @endif

                    <!-- Monthly Plan -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Plano Mensal</label>
                        <div class="flex items-center">
                            <input checked type="radio" id="monthly_plan_yes" name="monthly_plan" value="1" class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500" {{ old('monthly_plan') == '1' ? 'checked' : '' }} required>
                            <label for="monthly_plan_yes" class="ml-2 dark:text-gray-200 text-gray-800 text-sm">Sim</label>
                        </div>
                        <div class="flex items-center mt-2">
                            <input type="radio" id="monthly_plan_no" name="monthly_plan" value="0" class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500" {{ old('monthly_plan') == '0' ? 'checked' : '' }} required>
                            <label for="monthly_plan_no" class="ml-2 dark:text-gray-200 text-gray-800 text-sm">Não</label>
                        </div>
                        @error('monthly_plan')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button id="confirm-create-membership-button" type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300" disabled>Criar</button>
                        <button id="cancel-create-membership-button" type="button" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 dark:bg-gray-400 dark:text-gray-900 dark:hover:bg-gray-300">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <script>
        function createMembership() {
            document.getElementById('create-membership-modal').classList.remove('hidden');
        }

        document.getElementById('cancel-create-membership-button').addEventListener('click', function() {
            document.getElementById('create-membership-modal').classList.add('hidden');
        });

        const addressSelect = document.getElementById('address_id');
        const confirmButton = document.getElementById('confirm-create-membership-button');
        const form = document.getElementById('createMembershipForm');
        const questionnaireFilled = @json((bool)$user->membershipEntry());

        function checkFormCompletion() {
            if (addressSelect.value && document.querySelector('input[name="monthly_plan"]:checked') && questionnaireFilled) {
                confirmButton.disabled = false;
            } else {
                confirmButton.disabled = true;
            }
        }

        addressSelect.addEventListener('change', checkFormCompletion);
        document.querySelectorAll('input[name="monthly_plan"]').forEach(radio => {
            radio.addEventListener('change', checkFormCompletion);
        });

        document.getElementById('confirm-create-membership-button').addEventListener('click', function() {
            form.submit();
        });

        checkFormCompletion();
    </script>
</section>
