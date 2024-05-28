<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Matrícula') }}
        </h2>

        @if(!$user->membership)
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Ainda não possui Matrícula.') }}
            </p>

            <div class="flex items-center">
                <button type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150 " onclick="createMembership()">Realizar Matrícula</button>
            </div>
        @endif

        <!-- Criar Matricula Modal -->
        <div id="create-membership-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
            <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Matricula</h2>
                <form id="createMembershipForm" method="POST" action="{{ route('profile.membership.store') }}" class="mt-2 space-y-6">
                    @csrf
                @if($user->addresses && $user->addresses->count() > 0)
                        <div>
                            <x-input-label for="address" :value="__('Selecione uma morada')" class="mt-5 mb-1"/>
                            <select id="address" name="address" class="w-1/2 dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 dark:text-gray-900 focus:border-lime-500 dark:focus:border-lime-600 focus:ring-lime-500 dark:focus:ring-lime-600 rounded-md shadow-sm">
                                @foreach($user->addresses as $address)
                                    <option value="{{ $address->id }}" @if($loop->first) selected @endif>{{ $address->name }}</option>
                                @endforeach
                            </select>
                            @error('address')
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

                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Formulário</label>
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
                            <button type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">Preencher Formulario</button>
                        </a>
                    @endif

                    <!-- Monthly Plan -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Plano Mensal</label>
                        <div class="flex items-center">
                            <input type="radio" id="monthly_plan_yes" name="monthly_plan" value="1" class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500" {{ old('monthly_plan') == '1' ? 'checked' : '' }} required>
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
                        <button id="confirm-create-membership-button" type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Criar</button>
                        <button id="cancel-create-membership-button" type="button" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 dark:bg-gray-400 dark:text-gray-900 dark:hover:bg-gray-300">Cancelar</button>
                    </div>

                </form>
            </div>
        </div>





        <div class="flex justify-end gap-2">
            @if ($user->membership)
                <a href="{{ route('users.memberships.create', $user) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Criar Matrícula</a>
            @endif
        </div>

    </header>

    <script>
        function createMembership() {
            document.getElementById('create-membership-modal').classList.remove('hidden');
        }

        document.getElementById('cancel-create-membership-button').addEventListener('click', function() {
            document.getElementById('create-membership-modal').classList.add('hidden');
        });

        document.getElementById('confirm-create-membership-button').addEventListener('click', function() {
            document.getElementById('createMembershipForm').submit();
        });
    </script>
</section>


