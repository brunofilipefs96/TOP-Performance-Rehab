<x-app-layout>

    @component('components.sales.sale-list', ['sales' => $sales, 'status' => $status, 'nif' => $nif])
    @endcomponent

</x-app-layout>
