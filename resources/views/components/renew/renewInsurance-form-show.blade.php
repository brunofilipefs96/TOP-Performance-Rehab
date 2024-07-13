<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">1</span>
                    <span class="text text-gray-900 dark:text-white">Matrícula</span>
                    <span class="spacer"></span>
                </span>
                <span class="step active">
                    <span class="number text-gray-900 dark:text-white">2</span>
                    <span class="text text-gray-900 dark:text-white">Seguro</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">3</span>
                    <span class="text text-gray-900 dark:text-white">Seguro</span>
                    <span class="spacer"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-2xl bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Renovar Seguro</h1>
            </div>
            <form method="POST" action="{{ route('renew.updateInsurance', $user->membership->insurance) }}" enctype="multipart/form-data">
                @csrf
                @if ($user->membership->insurance->status->name != 'awaiting_membership')
                    @method('POST')
                @endif
                <div class="mb-4">
                    <label class="block text-sm font-medium dark:text-gray-200 text-gray-800 mt-6">Tipo de Seguro</label>
                    <div class="flex items-center mt-2">
                        <input type="radio" id="insurance_type_gym" name="insurance_type" value="Ginásio"
                               class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500"
                               {{ old('insurance_type', $user->membership->insurance->insurance_type ?? '') == 'Ginásio' ? 'checked' : '' }}
                               {{ $user->membership->insurance->status->name == 'awaiting_membership' ? 'disabled' : '' }} required>
                        <label for="insurance_type_gym" class="ml-2 dark:text-gray-200 text-gray-800">Ginásio</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="insurance_type_personal" name="insurance_type" value="Pessoal"
                               class="form-radio text-blue-500 dark:text-lime-400 h-4 w-4 dark:bg-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500"
                               {{ old('insurance_type', $user->membership->insurance->insurance_type ?? '') == 'Pessoal' ? 'checked' : '' }}
                               {{ $user->membership->insurance->status->name == 'awaiting_membership' ? 'disabled' : '' }} required>
                        <label for="insurance_type_personal" class="ml-2 dark:text-gray-200 text-gray-800">Pessoal</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data de Início</label>
                    <input type="date" id="start_date" name="start_date" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                           value="{{ old('start_date', optional($user->membership->insurance)->start_date ? \Carbon\Carbon::parse($user->membership->insurance->start_date)->format('Y-m-d') : '') }}"
                           {{ $user->membership->insurance->status->name == 'awaiting_membership' ? 'disabled' : '' }} required>
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data de Término</label>
                    <input type="date" id="end_date" name="end_date" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white"
                           value="{{ old('end_date', optional($user->membership->insurance)->end_date ? \Carbon\Carbon::parse($user->membership->insurance->end_date)->format('Y-m-d') : '') }}"
                           {{ $user->membership->insurance->status->name == 'awaiting_membership' ? 'disabled' : '' }} required>
                </div>
                <div class="flex justify-between items-center gap-2">
                    <a href="{{ route('renew.renewMembership') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 font-semibold flex items-center text-sm mt-4 mb-5 shadow-sm w-full justify-center max-w-[100px]">
                        <i class="fa-solid fa-arrow-left w-4 h-4 mr-2"></i>
                        Voltar
                    </a>
                    <div class="flex justify-between items-center gap-2">
                        @if($user->membership->insurance && $user->membership->insurance->status->name == 'inactive')
                            <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]">
                                Renovar
                                <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                            </button>
                        @elseif($user->membership->insurance && $user->membership->insurance->status->name != 'inactive')
                            <a href="{{ route('renew.renewAwaiting') }}"
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
        const insuranceTypeGym = document.getElementById('insurance_type_gym');
        const insuranceTypePersonal = document.getElementById('insurance_type_personal');
        const startDateField = document.getElementById('start_date');
        const endDateField = document.getElementById('end_date');

        function toggleDateFields() {
            if (insuranceTypeGym.checked) {
                startDateField.readOnly = true;
                endDateField.readOnly = true;
            } else {
                startDateField.readOnly = false;
                endDateField.readOnly = false;
            }
        }

        insuranceTypeGym.addEventListener('change', toggleDateFields);
        insuranceTypePersonal.addEventListener('change', toggleDateFields);

        // Initial check
        toggleDateFields();
    });
</script>
