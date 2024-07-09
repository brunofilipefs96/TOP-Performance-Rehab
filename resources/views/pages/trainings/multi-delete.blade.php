<x-app-layout>
    @component('components.trainings.training-multi-delete',
        [
            'trainings' => $trainings,
            'personalTrainers' => $personalTrainers,
            'trainingTypes' => $trainingTypes,
        ])
    @endcomponent
</x-app-layout>
