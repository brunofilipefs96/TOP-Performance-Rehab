<x-app-layout>

    @component('components.cart.cart-checkout', ['addresses' => $addresses, 'cart' => $cart, 'packCart' => $packCart])
    @endcomponent

</x-app-layout>
