<x-app-layout>
    @component('components.trainings.training-list', [
        'trainings' => $trainings,
        'currentWeek' => $currentWeek,
        'selectedWeek' => $selectedWeek,
        'daysOfWeek' => $daysOfWeek,
        'showMembershipModal' => $showMembershipModal,
    ])
    @endcomponent
</x-app-layout>
