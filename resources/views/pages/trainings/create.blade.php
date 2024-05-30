<x-app-layout>

    @component('components.trainings.training-form-create', ['trainingTypes' => $trainingTypes, 'rooms' => $rooms])
    @endcomponent

</x-app-layout>
