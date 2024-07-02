<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
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
                <span class="step active">
                    <span class="number text-gray-900 dark:text-white">4</span>
                    <span class="text text-gray-900 dark:text-white">Seguro</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">5</span>
                    <span class="text last text-gray-900 dark:text-white">Pagamento</span>
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
                               {{ old('insurance_type', $user->membership->insurance->insurance_type ?? '') == 'Ginásio' ? 'checked' : '' }}
                               {{ $user->membership->insurance ? 'disabled' : '' }} required>
                        <label for="insurance_type_gym" class="ml-2 dark:text-gray-200 text-gray-800">Ginásio</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="insurance_type_personal" name="insurance_type" value="Pessoal"
                               class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500"
                               {{ old('insurance_type', $user->membership->insurance->insurance_type ?? '') == 'Pessoal' ? 'checked' : '' }}
                               {{ $user->membership->insurance ? 'disabled' : '' }} required>
                        <label for="insurance_type_personal" class="ml-2 dark:text-gray-200 text-gray-800">Pessoal</label>
                    </div>
                    @error('insurance_type')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4" id="date_fields" style="display: {{ old('insurance_type', $user->membership->insurance->insurance_type ?? '') == 'Pessoal' ? 'block' : 'none' }};">
                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data de Início</label>
                        <input type="date" id="start_date" name="start_date" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                               value="{{ old('start_date', $user->membership->insurance->start_date ?? '') }}"
                            {{ $user->membership->insurance ? 'disabled' : '' }}>
                        @error('start_date')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data de Término</label>
                        <input type="date" id="end_date" name="end_date" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                               value="{{ old('end_date', $user->membership->insurance->end_date ?? '') }}"
                            {{ $user->membership->insurance ? 'disabled' : '' }}>
                        @error('end_date')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between items-center gap-2">
                    <a href="{{ route('setup.trainingTypesShow') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 font-semibold flex items-center text-sm mt-4 mb-5 shadow-sm w-full justify-center max-w-[100px]">
                        <i class="fa-solid fa-arrow-left w-4 h-4 mr-2"></i>
                        Voltar
                    </a>

                    <div class="flex gap-2 items-center">
                        @if(!$user->membership->insurance)
                            <p id="insurance_message" class="mt-1 text-sm text-red-500">
                                {{ __("Você precisa selecionar um tipo de seguro antes de continuar.") }}
                            </p>
                            <button id="insurance_submit_button" type="submit" style="display: none;"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]">
                                Avançar
                                <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                            </button>
                        @else
                            <a href="{{ route('setup.awaitingShow') }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]">
                                Avançar
                                <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                            </a>
                        @endif
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
        const insuranceSubmitButton = document.getElementById('insurance_submit_button');
        const insuranceMessage = document.getElementById('insurance_message');

        function toggleDateFields() {
            if (insuranceTypePersonal.checked) {
                dateFields.style.display = 'block';
                const today = new Date();
                const startDate = today.toISOString().split('T')[0];
                const endDate = new Date(today.setFullYear(today.getFullYear() + 1)).toISOString().split('T')[0];
                if (!startDateField.value) {
                    startDateField.value = startDate;
                }
                if (!endDateField.value) {
                    endDateField.value = endDate;
                }
            } else {
                dateFields.style.display = 'none';
                startDateField.value = '';
                endDateField.value = '';
            }
        }

        function toggleSubmitButton() {
            if (insuranceTypePersonal.checked || insuranceTypeGym.checked) {
                insuranceSubmitButton.style.display = 'block';
                insuranceMessage.style.display = 'none';
            } else {
                insuranceSubmitButton.style.display = 'none';
                insuranceMessage.style.display = 'block';
            }
        }

        insuranceTypePersonal.addEventListener('change', toggleDateFields);
        insuranceTypePersonal.addEventListener('change', toggleSubmitButton);
        insuranceTypeGym.addEventListener('change', toggleDateFields);
        insuranceTypeGym.addEventListener('change', toggleSubmitButton);

        // Initialize the state on page load
        toggleDateFields();
        toggleSubmitButton();
    });
</script>
