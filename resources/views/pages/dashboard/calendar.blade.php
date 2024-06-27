
<x-app-layout>

    @component('components.calendar.calendar-show', ['user' => $user,
            'trainings' => $trainings,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'currentWeek' => $currentWeek])
    @endcomponent

</x-app-layout>
