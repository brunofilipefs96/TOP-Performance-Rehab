
<x-app-layout>

    @component('components.calendar.calendar-show', ['user' => $user,
            'user' => $user,
            'trainings' => $trainings,
            'freeTrainings' => $freeTrainings,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'selectedWeek' => $selectedWeek,
            'currentWeek' => $currentWeek,])
    @endcomponent

</x-app-layout>
