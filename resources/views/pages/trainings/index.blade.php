<x-app-layout>

    @component('components.trainings.training-list', ['trainings' => $trainings, 'trainingTypes' => $trainingTypes])
    @endcomponent

</x-app-layout>
