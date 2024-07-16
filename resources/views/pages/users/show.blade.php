<x-app-layout>

    @component('components.users.user-form-show', [
            'user' => $user,
            'roles' => $roles,
            'clientTypes' => $clientTypes,
            ])
    @endcomponent

</x-app-layout>
