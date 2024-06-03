<x-app-layout>

    @component('components.trainings.training-form-create', ['trainingTypes' => $trainingTypes, 'rooms' => $rooms, 'personalTrainers' => $personalTrainers])
    @endcomponent

</x-app-layout>
