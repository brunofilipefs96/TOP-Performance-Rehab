
<div class="container mt-5">
    <h1>Lista de Salas</h1>
    @can('create', App\Models\Room::class)
    <a href="{{ url('rooms/create') }}"><button type="button">Adicionar Salas</button></a>
    @endcan
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Capacidade</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($rooms as $room)
            <tr>
                <td>{{ $room->id }}</td>
                <td>{{ $room->name }}</td>
                <td>{{ $room->capacity }}</td>
                <td>
                    <a href="{{ url('rooms/' . $room->id)  }}"><button type="button">Mostrar</button></a>
                        @can('update', $room)
                        <a href="{{ url('rooms/' . $room->id) . '/edit' }}"><button type="button">Editar</button></a>
                        @endcan
                        @can('delete', $room)
                        <form action="{{url('rooms/' . $room->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                        @endcan
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4 mb-3 pages">
        {{ $rooms->links() }}
    </div>

</div>
