<x-app-layout>

    @component('components.trainings.training-form-edit', ['training' => $training, 'trainingTypes' => $trainingTypes, 'rooms' => $rooms, 'personalTrainers' => $personalTrainers, 'closures' => $closures])
    @endcomponent

</x-app-layout>
