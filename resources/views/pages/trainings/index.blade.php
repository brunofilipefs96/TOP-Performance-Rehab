<x-app-layout>
    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Treinos</h1>

        <!-- Selector for Training Type -->
        <div class="mb-10 flex items-center">
            <label for="trainingTypeSelector" class="mr-3 text-lg font-medium text-gray-700 dark:text-gray-200">
                Tipo de Treino:
            </label>
            <select id="trainingTypeSelector" class="w-auto dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm" style="padding-right: 1.5rem;" onchange="changeTrainingType()">
                <option value="accompanied" {{ request()->routeIs('trainings.index') ? 'selected' : '' }}>Acompanhado</option>
                <option value="free" {{ request()->routeIs('free-trainings.index') ? 'selected' : '' }}>Livre</option>
            </select>
        </div>

        <!-- Include the appropriate component based on the selected type -->
        @if(request()->routeIs('trainings.index'))
            @component('components.trainings.training-list', [
                'trainings' => $trainings,
                'currentWeek' => $currentWeek,
                'selectedWeek' => $selectedWeek,
                'daysOfWeek' => $daysOfWeek,
                'type' => 'accompanied',
                'showMembershipModal' => $showMembershipModal,
                'closures' => $closures,
            ])
            @endcomponent
        @else
            @component('components.free-trainings.free-training-list', [
                'freeTrainings' => $freeTrainings,
                'currentWeek' => $currentWeek,
                'selectedWeek' => $selectedWeek,
                'daysOfWeek' => $daysOfWeek,
                'selectedDay' => $selectedDay,
                'showMembershipModal' => $showMembershipModal,
            ])
            @endcomponent
        @endif
    </div>
</x-app-layout>

<script>
    function changeTrainingType() {
        const type = document.getElementById('trainingTypeSelector').value;
        window.location.href = type === 'free' ? '{{ route('free-trainings.index') }}' : '{{ route('trainings.index') }}';
    }
</script>
