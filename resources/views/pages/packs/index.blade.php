<x-app-layout>

    @component('components.packs.pack-list', ['packs' => $packs, 'showMembershipModal' => $showMembershipModal, 'filter' => $filter])
    @endcomponent

</x-app-layout>
