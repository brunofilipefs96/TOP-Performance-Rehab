<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <div>
                <h1 class="mb-2 dark:text-lime-400 font-semibold text-gray-800">Criar Serviço</h1>
            </div>
                <form method="POST" action="{{ route('services.store') }}" id="serviceForm" onsubmit="disableConfirmButton(this)">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block dark:text-white text-gray-800">Nome</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="employee_id" class="block dark:text-white text-gray-800">Funcionario</label>
                        @can('manage-services') <!-- Only show this to admin users -->
                        <select name="employee_id" id="employee_id" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->firstLastName() }}</option>
                            @endforeach
                        </select>
                        @else
                            <input type="hidden" name="employee_id" id="employee_id" value="{{ auth()->user()->id }}">
                            <input type="text" value="{{ auth()->user()->firstLastName() }}" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" readonly>
                        @endcan
                        @error('employee_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="start_date" class="block dark:text-white text-gray-800">Início</label>
                        <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        <p class="text-gray-500 text-sm">A duração mínima é de 20 minutos e a duração máxima é de 2 horas.</p>
                        @error('start_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="end_date" class="block dark:text-white text-gray-800">Término</label>
                        <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                        @error('end_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <span id="time-error-msg" class="text-red-500 text-sm"></span>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Criar Serviço</button>
                </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startTimeInput = document.getElementById('start_date');
        const endTimeInput = document.getElementById('end_date');
        const form = document.getElementById('serviceForm');
        const errorMsg = document.getElementById('time-error-msg');

        form.addEventListener('submit', function (event) {
            const startTime = new Date(startTimeInput.value);
            const endTime = new Date(endTimeInput.value);
            const now = new Date();

            if (startTime < now) {
                event.preventDefault();
                errorMsg.innerText = 'A hora de início deve ser superior à hora atual.';
                return false;
            } else if (startTime >= endTime) {
                event.preventDefault();
                errorMsg.innerText = 'A hora de término deve ser superior à hora de início.';
                return false;
            } else if ((endTime - startTime) / (1000 * 60) < 20) {
                event.preventDefault();
                errorMsg.innerText = 'A duração do serviço deve ser de pelo menos 20 minutos.';
                return false;
            } else if ((endTime - startTime) / (1000 * 60) > 120) {
                event.preventDefault();
                errorMsg.innerText = 'A duração do serviço não pode exceder 2 horas.';
                return false;
            } else {
                errorMsg.innerText = '';
            }
        });
    });
</script>
