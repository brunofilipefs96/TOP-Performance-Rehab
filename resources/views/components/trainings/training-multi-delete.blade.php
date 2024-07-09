@php
    use Carbon\Carbon;
@endphp
<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-6xl dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ url()->previous() }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Remover Vários Treinos</h1>
            </div>
            @if(session('success'))
                <div class="text-green-500 text-sm mb-5">
                    {{ session('success') }}
                </div>
            @endif

            <form id="filterForm" method="GET" action="{{ route('trainings.showMultiDelete') }}" class="mb-5">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-4 justify-start">
                    @if(auth()->user()->hasRole('admin'))
                        <div class="flex items-center space-x-2">
                            <label for="personal_trainer_id" class="text-gray-700 dark:text-gray-300">Personal Trainer:</label>
                            <select name="personal_trainer_id" id="personal_trainer_id" class="form-select w-full md:w-auto dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm" onchange="document.getElementById('filterForm').submit();">
                                <option value="">Todos</option>
                                @foreach ($personalTrainers as $trainer)
                                    <option value="{{ $trainer->id }}" {{ request('personal_trainer_id') == $trainer->id ? 'selected' : '' }}>
                                        {{ $trainer->firstLastName() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="flex items-center space-x-2">
                        <label for="training_type_id" class="text-gray-700 dark:text-gray-300">Tipo de Treino:</label>
                        <select name="training_type_id" id="training_type_id" class="form-select w-full md:w-auto dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm" onchange="document.getElementById('filterForm').submit();">
                            <option value="">Todos</option>
                            @foreach ($trainingTypes as $type)
                                <option value="{{ $type->id }}" {{ request('training_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            @if($trainings->count() > 0)
                <form id="deleteForm" method="POST" action="{{ route('trainings.multiDelete') }}">
                    @csrf
                    @method('DELETE')
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="py-2 px-4 border-b dark:border-gray-700 text-left">
                                    <input type="checkbox" onclick="toggle(this)">
                                </th>
                                <th class="py-2 px-4 border-b dark:border-gray-700 text-left">Treino</th>
                                <th class="py-2 px-4 border-b dark:border-gray-700 text-left">Hora de Início</th>
                                <th class="py-2 px-4 border-b dark:border-gray-700 text-left">Hora de Fim</th>
                                <th class="py-2 px-4 border-b dark:border-gray-700 text-left">Personal Trainer</th>
                                <th class="py-2 px-4 border-b dark:border-gray-700 text-left">Tipo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($trainings as $training)
                                <tr>
                                    <td class="py-2 px-4 border-b text-left dark:border-gray-700">
                                        <input type="checkbox" name="trainings[]" value="{{ $training->id }}" class="training-checkbox">
                                    </td>
                                    <td class="py-2 px-4 border-b dark:border-gray-700 text-left">{{ $training->name }}</td>
                                    <td class="py-2 px-4 border-b dark:border-gray-700 text-left">{{ Carbon::parse($training->start_date)->format('H:i') }}</td>
                                    <td class="py-2 px-4 border-b dark:border-gray-700 text-left">{{ Carbon::parse($training->end_date)->format('H:i') }}</td>
                                    <td class="py-2 px-4 border-b dark:border-gray-700 text-left">{{ $training->personalTrainer->firstLastName() }}</td>
                                    <td class="py-2 px-4 border-b dark:border-gray-700 text-left">{{ $training->trainingType->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" id="deleteButton" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500 flex items-center" onclick="confirmDelete()" disabled>
                            <i class="fa-solid fa-trash-can mr-2"></i> Remover Selecionados
                        </button>
                    </div>
                </form>

                <div class="mt-4">
                    {{ $trainings->links() }}
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">Nenhum treino disponível para remoção.</p>
            @endif
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Confirmar Remoção</h2>
        <p class="mb-4 text-gray-700 dark:text-gray-200">Tem a certeza de que deseja remover os treinos selecionados? Esta ação não pode ser desfeita.</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="closeModal()">Cancelar</button>
            <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500" onclick="submitDeleteForm()">Remover</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.training-checkbox');
        const deleteButton = document.getElementById('deleteButton');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (document.querySelectorAll('.training-checkbox:checked').length > 0) {
                    deleteButton.disabled = false;
                } else {
                    deleteButton.disabled = true;
                }
            });
        });
    });

    function toggle(source) {
        checkboxes = document.querySelectorAll('.training-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = source.checked;
        });
        const deleteButton = document.getElementById('deleteButton');
        deleteButton.disabled = !source.checked;
    }

    function confirmDelete() {
        document.getElementById('confirmationModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }

    function submitDeleteForm() {
        document.getElementById('deleteForm').submit();
    }
</script>
