<x-app-layout>
    <div class="container mx-auto mt-10 mb-10 px-4">
        <h1 class="text-2xl mb-4 font-bold text-gray-800 dark:text-gray-200">Minhas Notificações</h1>

        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg max-w-full px-4">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mb-10">
                    <h3 class="text-2xl font-medium mb-3 text-center">Notificações</h3>

                    <div class="flex justify-between mb-4">
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-blue-500 dark:bg-lime-500 hover:bg-blue-400 dark:hover:bg-lime-400 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Marcar todas como lidas
                            </button>
                        </form>
                        <form action="{{ route('notifications.deleteAll') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Eliminar todas
                            </button>
                        </form>
                    </div>

                    @if ($notifications->isEmpty())
                        <p class="text-gray-800 dark:text-gray-200 text-center">Você não tem notificações.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($notifications as $notification)
                                <li class="bg-gray-300 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                                    <a href="{{ route('notifications.redirect', $notification->id) }}" class="block hover:bg-gray-400 dark:hover:bg-gray-600 rounded-lg p-4">
                                        <h5 class="text-gray-800 dark:text-gray-200 flex items-center">
                                            <i class="fa-solid {{ $notification->pivot->read_at ? 'fa-check-double text-green-500' : 'fa-envelope text-blue-500' }} mr-2"></i>
                                            {{ $notification->notificationType->name }}
                                        </h5>
                                        <p class="text-gray-800 dark:text-gray-200">{{ $notification->message }}</p>
                                        <p><small class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($notification->pivot->created_at)->format('d/m/Y H:i:s') }}</small></p>
                                        @if (is_null($notification->pivot->read_at))
                                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline-block mt-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-900 font-bold py-2 px-4 rounded inline-flex items-center">
                                                    <i class="fas fa-check mr-2"></i>
                                                    Marcar como lida
                                                </button>
                                            </form>
                                        @else
                                            <p><small class="text-gray-600 dark:text-gray-400">Leitura em: {{ \Carbon\Carbon::parse($notification->pivot->read_at)->format('d/m/Y H:i:s') }}</small></p>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
