<x-app-layout>
    @component('components.trainings.training-list', [
        'trainings' => $trainings,
        'currentWeek' => $currentWeek,
        'selectedWeek' => $selectedWeek,
        'daysOfWeek' => $daysOfWeek
    ])
    @endcomponent
</x-app-layout>
