@php
    use Carbon\Carbon;
@endphp
<div class="container mx-auto mt-10 mb-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-6xl dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ url()->previous() }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Remover Vários Treinos Livres</h1>
            </div>
            @if(session('success'))
                <div class="text-green-500 text-sm mb-5">
                    {{ session('success') }}
                </div>
            @endif

            @if($freeTrainings->count() > 0)
                <form id="deleteForm" method="POST" action="{{ route('free-trainings.multiDelete') }}">
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
                                <th class="py-2 px-4 border-b dark:border-gray-700 text-left">Data</th>
                                <th class="py-2 px-4 border-b dark:border-gray-700 text-left">Hora de Início</th>
                                <th class="py-2 px-4 border-b dark:border-gray-700 text-left">Hora de Fim</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($freeTrainings as $freeTraining)
                                <tr>
                                    <td class="py-2 px-4 border-b text-left dark:border-gray-700">
                                        <input type="checkbox" name="free_trainings[]" value="{{ $freeTraining->id }}" class="free-training-checkbox">
                                    </td>
                                    <td class="py-2 px-4 border-b dark:border-gray-700 text-left">{{ $freeTraining->name }}</td>
                                    <td class="py-2 px-4 border-b dark:border-gray-700 text-left">{{ Carbon::parse($freeTraining->start_date)->format('d/m/Y') }}</td>
                                    <td class="py-2 px-4 border-b dark:border-gray-700 text-left">{{ Carbon::parse($freeTraining->start_date)->format('H:i') }}</td>
                                    <td class="py-2 px-4 border-b dark:border-gray-700 text-left">{{ Carbon::parse($freeTraining->end_date)->format('H:i') }}</td>
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
                    {{ $freeTrainings->links() }}
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">Nenhum treino livre disponível para remoção.</p>
            @endif
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Confirmar Remoção</h2>
        <p class="mb-4 text-gray-700 dark:text-gray-200">Tem a certeza de que deseja remover os treinos livres selecionados? Esta ação não pode ser desfeita.</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="closeModal()">Cancelar</button>
            <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500" onclick="submitDeleteForm()">Remover</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.free-training-checkbox');
        const deleteButton = document.getElementById('deleteButton');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (document.querySelectorAll('.free-training-checkbox:checked').length > 0) {
                    deleteButton.disabled = false;
                } else {
                    deleteButton.disabled = true;
                }
            });
        });
    });

    function toggle(source) {
        checkboxes = document.querySelectorAll('.free-training-checkbox');
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
