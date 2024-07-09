<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">

            <div class="text-center">
                <h1 class="mb-8 mt-4 dark:text-lime-400 text-gray-800 font-semibold">Avaliação de {{ $evaluation->membership->user->full_name }} {{ $evaluation->date }}</h1>
            </div>

            <!-- Campos de Avaliação -->
            <div class="mb-4">
                <label for="weight" class="block text-gray-800 dark:text-white">Peso</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->weight }}" disabled>
            </div>

            <div class="mb-4">
                <label for="height" class="block text-gray-800 dark:text-white">Altura</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->height }}" disabled>
            </div>

            <div class="mb-4">
                <label for="waist" class="block text-gray-800 dark:text-white">Cintura</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->waist }}" disabled>
            </div>

            <div class="mb-4">
                <label for="hip" class="block text-gray-800 dark:text-white">Quadril</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->hip }}" disabled>
            </div>

            <div class="mb-4">
                <label for="chest" class="block text-gray-800 dark:text-white">Peito</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->chest }}" disabled>
            </div>

            <div class="mb-4">
                <label for="arm" class="block text-gray-800 dark:text-white">Braço</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->arm }}" disabled>
            </div>

            <div class="mb-4">
                <label for="forearm" class="block text-gray-800 dark:text-white">Antebraço</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->forearm }}" disabled>
            </div>

            <div class="mb-4">
                <label for="thigh" class="block text-gray-800 dark:text-white">Coxa</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->thigh }}" disabled>
            </div>

            <div class="mb-4">
                <label for="calf" class="block text-gray-800 dark:text-white">Panturrilha</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->calf }}" disabled>
            </div>

            <div class="mb-4">
                <label for="abdominal_fat" class="block text-gray-800 dark:text-white">Gordura Abdominal</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->abdominal_fat }}" disabled>
            </div>

            <div class="mb-4">
                <label for="visceral_fat" class="block text-gray-800 dark:text-white">Gordura Visceral</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->visceral_fat }}" disabled>
            </div>

            <div class="mb-4">
                <label for="muscle_mass" class="block text-gray-800 dark:text-white">Massa Muscular</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->muscle_mass }}" disabled>
            </div>

            <div class="mb-4">
                <label for="fat_mass" class="block text-gray-800 dark:text-white">Massa Gorda</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->fat_mass }}" disabled>
            </div>

            <div class="mb-4">
                <label for="hydration" class="block text-gray-800 dark:text-white">Hidratação</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->hydration }}" disabled>
            </div>

            <div class="mb-4">
                <label for="bone_mass" class="block text-gray-800 dark:text-white">Massa Óssea</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->bone_mass }}" disabled>
            </div>

            <div class="mb-4">
                <label for="bmr" class="block text-gray-800 dark:text-white">Taxa Metabólica Basal</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->bmr }}" disabled>
            </div>

            <div class="mb-4">
                <label for="metabolic_age" class="block text-gray-800 dark:text-white">Idade Metabólica</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->metabolic_age }}" disabled>
            </div>

            <div class="mb-4">
                <label for="physical_evaluation" class="block text-gray-800 dark:text-white">Avaliação Física</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->physical_evaluation }}" disabled>
            </div>

            <div class="mb-4">
                <label for="fat_percentage" class="block text-gray-800 dark:text-white">Percentual de Gordura</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->fat_percentage }}" disabled>
            </div>

            <div class="mb-4">
                <label for="imc" class="block text-gray-800 dark:text-white">IMC</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->imc }}" disabled>
            </div>

            <div class="mb-4">
                <label for="ideal_weight" class="block text-gray-800 dark:text-white">Peso Ideal</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->ideal_weight }}" disabled>
            </div>

            <div class="mb-4">
                <label for="ideal_fat_percentage" class="block text-gray-800 dark:text-white">Percentual de Gordura Ideal</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->ideal_fat_percentage }}" disabled>
            </div>

            <div class="mb-4">
                <label for="ideal_muscle_mass" class="block text-gray-800 dark:text-white">Massa Muscular Ideal</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="number" value="{{ $evaluation->ideal_muscle_mass }}" disabled>
            </div>

            <div class="mb-4">
                <label for="observations" class="block text-gray-800 dark:text-white">Observações</label>
                <textarea class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" disabled>{{ $evaluation->observations }}</textarea>
            </div>

            <div class="flex justify-between items-center mb-4 mt-10">
                <a href="{{ route('memberships.evaluations.list', ['membership' => $evaluation->membership_id]) }}" class="bg-gray-500 text-white flex items-center px-4 py-2 rounded-md hover:bg-gray-400 dark:bg-gray-500 dark:hover:bg-gray-400 mr-2">
                    <i class="fa-solid fa-arrow-left w-4 h-4 mr-2"></i>
                    Voltar à Lista
                </a>
                @can('delete', $evaluation)
                    <form id="delete-form-{{$evaluation->id}}" action="{{ route('memberships.evaluations.destroy', ['membership' => $evaluation->membership_id, 'evaluation' => $evaluation->id]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="bg-red-600 text-white flex items-center px-4 py-2 rounded-md hover:bg-red-500" onclick="confirmDelete({{ $evaluation->id }})">
                            <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                            Eliminar
                        </button>
                    </form>
                @endcan
            </div>

        </div>
    </div>
</div>

<div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelAction()">Cancelar</button>
            <button type="button" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500" onclick="confirmAction()">Confirmar</button>
        </div>
    </div>
</div>

<script>
    let evaluationDeleted = 0;

    function confirmDelete(id) {
        document.getElementById('confirmation-modal').classList.remove('hidden');
        evaluationDeleted = id;
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function confirmAction() {
        document.getElementById(`delete-form-${evaluationDeleted}`).submit();
    }
</script>
