<x-app-layout>

    @component('components.products.product-list', ['products' => $products, 'message' => $message])
    @endcomponent

</x-app-layout>
