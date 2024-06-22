<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
                <span class="step complete">
                    <span class="number"><i class="fa-solid fa-check"></i></span>
                    <span class="text">Morada</span>
                    <span class="spacer"></span>
                </span>
                <span class="step complete">
                    <span class="number"><i class="fa-solid fa-check"></i></span>
                    <span class="text">Matrícula</span>
                    <span class="spacer"></span>
                </span>
                <span class="step complete">
                    <span class="number"><i class="fa-solid fa-check"></i></span>
                    <span class="text">Modalidades</span>
                    <span class="spacer"></span>
                </span>
                <span class="step active">
                    <span class="number">4</span>
                    <span class="text">Seguro</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number">5</span>
                    <span class="text last">Pagamento</span>
                </span>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-2xl bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <header>
                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Adicionar Seguro') }}
                </h2>
            </header>

            <div class="mb-4">
                <label for="name" class="block text-gray-800 dark:text-white">Nome</label>
                <input type="text" value="{{ Auth::user()->full_name }}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <form method="POST" action="{{ route('insurances.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800">Tipo de Seguro</label>
                    <div class="flex items-center mt-2">
                        <input type="radio" id="insurance_type_gym" name="insurance_type" value="Ginásio"
                               class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500"
                               {{ old('insurance_type') == 'Ginásio' ? 'checked' : '' }} required>
                        <label for="insurance_type_gym" class="ml-2 dark:text-gray-200 text-gray-800">Ginásio</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="insurance_type_personal" name="insurance_type" value="Pessoal"
                               class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500"
                               {{ old('insurance_type') == 'Pessoal' ? 'checked' : '' }} required>
                        <label for="insurance_type_personal" class="ml-2 dark:text-gray-200 text-gray-800">Pessoal</label>
                    </div>
                    @error('insurance_type')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4" id="date_fields" style="display: none;">
                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data de Início</label>
                        <input type="date" id="start_date" name="start_date" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" value="{{ old('start_date') }}">
                        @error('start_date')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data de Término</label>
                        <input type="date" id="end_date" name="end_date" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" value="{{ old('end_date') }}">
                        @error('end_date')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between items-center gap-2">
                    <a href="{{ route('setup.trainingTypesShow') }}"
                       class="inline-block bg-gray-500 mt-4 mb-5 py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 text-white">
                        Voltar
                    </a>
                    <div class="flex gap-2">
                        <button id="submit-button" type="submit"
                                class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 hidden">
                            Seguir
                        </button>
                    </div>
                    <div id="warning-message" class="text-red-500 text-sm mt-2 hidden">
                        <strong>Por favor, selecione um tipo de seguro.</strong>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const insuranceTypePersonal = document.getElementById('insurance_type_personal');
        const insuranceTypeGym = document.getElementById('insurance_type_gym');
        const dateFields = document.getElementById('date_fields');
        const startDateField = document.getElementById('start_date');
        const endDateField = document.getElementById('end_date');
        const submitButton = document.getElementById('submit-button');
        const warningMessage = document.getElementById('warning-message');

        function toggleDateFields() {
            if (insuranceTypePersonal.checked) {
                dateFields.style.display = 'block';
                const today = new Date();
                const startDate = today.toISOString().split('T')[0];
                const endDate = new Date(today.setFullYear(today.getFullYear() + 1)).toISOString().split('T')[0];
                startDateField.value = startDate;
                endDateField.value = endDate;
            } else {
                dateFields.style.display = 'none';
                startDateField.value = '';
                endDateField.value = '';
            }
        }

        function toggleSubmitButton() {
            if (insuranceTypePersonal.checked || insuranceTypeGym.checked) {
                submitButton.classList.remove('hidden');
                warningMessage.classList.add('hidden');
            } else {
                submitButton.classList.add('hidden');
                warningMessage.classList.remove('hidden');
            }
        }

        insuranceTypePersonal.addEventListener('change', function () {
            toggleDateFields();
            toggleSubmitButton();
        });
        insuranceTypeGym.addEventListener('change', function () {
            toggleDateFields();
            toggleSubmitButton();
        });

        // Initialize the state on page load
        toggleDateFields();
        toggleSubmitButton();
    });
</script>
