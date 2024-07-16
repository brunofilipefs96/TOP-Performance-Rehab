<x-app-layout>

    @component('components.users.user-form-show', [
            'user' => $user,
            'roles' => $roles,])
    @endcomponent

</x-app-layout>
