
<x-app-layout>
    <div class="container">
        <h1>Minhas Notificações</h1>
        @if ($notifications->isEmpty())
            <p>Você não tem notificações.</p>
        @else
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <li class="list-group-item">
                        <h5>{{ $notification->notificationType->name }}</h5>
                        <p>{{ $notification->message }}</p>
                        <p><small>{{ $notification->pivot->created_at->format('d/m/Y H:i:s') }}</small></p>
                        @if (is_null($notification->pivot->read_at))
                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary btn-sm">Marcar como lida</button>
                            </form>
                        @else
                            <p><small>Leitura em: {{ $notification->pivot->read_at->format('d/m/Y H:i:s') }}</small></p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
