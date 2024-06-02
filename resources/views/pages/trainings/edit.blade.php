<x-app-layout>

    @component('components.trainings.training-form-edit', ['training' => $training, 'trainingTypes' => $trainingTypes, 'rooms' => $rooms, 'personalTrainers' => $personalTrainers])
    @endcomponent

</x-app-layout>
