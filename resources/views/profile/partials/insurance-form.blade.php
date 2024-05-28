<section>
    <header>
        <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">
            {{ __('Seguro') }}
        </h2>
    </header>

    @if($user->membership)
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Necessita de preencher o seguro.') }}
        </p>

        <div class="flex items-center">
            <button type="button" class="inline-flex items-center px-4 py-2 mt-6 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150" onclick="createInsurance()">
                Preencher Seguro
            </button>
        </div>

        <div id="create-insurance-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
            <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Inserir Seguro</h2>

                <form id="createInsuranceForm" method="POST" action="{{ route('insurance.store') }}" class="mt-2 space-y-6">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Tipo de Seguro</label>
                        <div class="flex items-center">
                            <input type="radio" id="insurance_type_personal" name="insurance_type" value="Pessoal" class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500" checked required>
                            <label for="insurance_type_personal" class="ml-2 dark:text-gray-200 text-gray-800 text-sm">Pessoal</label>
                        </div>
                        <div class="flex items-center mt-2">
                            <input type="radio" id="insurance_type_gym" name="insurance_type" value="Ginasio" class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500" required>
                            <label for="insurance_type_gym" class="ml-2 dark:text-gray-200 text-gray-800 text-sm">Ginasio</label>
                        </div>
                    </div>


                    <div id="date-fields" class="space-y-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data de Início</label>
                            <x-text-input id="create_start_date" name="start_date" type="date" class="mt-1 block w-full" />
                            @error('start_date')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data de Término</label>
                            <x-text-input id="create_end_date" name="end_date" type="date" class="mt-1 block w-full" />
                            @error('end_date')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <button id="confirm-create-insurance-button" type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300">Criar</button>
                        <button id="cancel-create-insurance-button" type="button" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 dark:bg-gray-400 dark:text-gray-900 dark:hover:bg-gray-300">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Ainda não possui Matrícula.') }}
        </p>
    @endif

    <script>
        function createInsurance() {
            document.getElementById('create-insurance-modal').classList.remove('hidden');
        }

        document.getElementById('cancel-create-insurance-button').addEventListener('click', function() {
            document.getElementById('create-insurance-modal').classList.add('hidden');
        });

        document.getElementById('confirm-create-insurance-button').addEventListener('click', function() {
            const insuranceType = document.querySelector('input[name="insurance_type"]:checked').value;
            const startDateInput = document.getElementById('create_start_date');
            const endDateInput = document.getElementById('create_end_date');

            if (insuranceType === 'Ginasio') {
                const startDate = new Date();
                const endDate = new Date();
                endDate.setFullYear(startDate.getFullYear() + 1);

                startDateInput.value = startDate.toISOString().slice(0, 16);
                endDateInput.value = endDate.toISOString().slice(0, 16);
            }

            if (!validateDates()) {
                return;
            }

            document.getElementById('createInsuranceForm').submit();
        });

        function validateDates() {
            const startDateInput = document.getElementById('create_start_date');
            const endDateInput = document.getElementById('create_end_date');

            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (endDate <= startDate) {
                alert('A data de término deve ser posterior à data de início.');
                return false;
            }

            return true;
        }

        document.querySelectorAll('input[name="insurance_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const dateFields = document.getElementById('date-fields');
                const startDateInput = document.getElementById('create_start_date');
                const endDateInput = document.getElementById('create_end_date');

                if (this.value === 'Ginasio') {
                    dateFields.classList.add('hidden');
                    startDateInput.removeAttribute('required');
                    endDateInput.removeAttribute('required');
                } else {
                    dateFields.classList.remove('hidden');
                    startDateInput.setAttribute('required', 'required');
                    endDateInput.setAttribute('required', 'required');
                }
            });
        });
    </script>
</section>
