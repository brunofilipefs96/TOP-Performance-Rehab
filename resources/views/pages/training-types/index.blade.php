<x-app-layout>

    @component('components.training-types.training-type-list', ['training_types' => $training_types, 'filter' => $filter])
    @endcomponent

</x-app-layout>
