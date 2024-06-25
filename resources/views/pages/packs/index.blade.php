<x-app-layout>

    @component('components.packs.pack-list', ['packs' => $packs, 'showMembershipModal' => $showMembershipModal])
    @endcomponent

</x-app-layout>
