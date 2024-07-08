<x-app-layout>

    @component('components.evaluations.evaluation-form-list', ['evaluations' => $evaluations, 'membership' => $membership] )
    @endcomponent

</x-app-layout>

