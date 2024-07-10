<x-app-layout>

    @component('components.trainings.training-form-create', ['trainingTypes' => $trainingTypes, 'rooms' => $rooms, 'personalTrainers' => $personalTrainers, 'closures' => $closures])
    @endcomponent

</x-app-layout>
