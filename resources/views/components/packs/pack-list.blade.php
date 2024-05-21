<div class="container mt-5">
    <h1>Lista de Pacotes</h1>
    @can('create', App\Models\Pack::class)
    <a href="{{ url('packs/create') }}"><button type="button">Adicionar Pacote</button></a>
    @endcan
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Numero de Treinos</th>
            <th>Pesonal Trainer</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($packs as $pack)
            <tr>
                <td>{{ $pack->id }}</td>
                <td>{{ $pack->name }}</td>
                <td>{{ $pack->trainings_number }}</td>
                <td>
                    <input type="radio" name="personal_trainer_{{ $pack->id }}" value="1" {{ $pack->has_personal_trainer ? 'checked' : '' }} disabled> Sim
                    <input type="radio" name="personal_trainer_{{ $pack->id }}" value="0" {{ !$pack->has_personal_trainer ? 'checked' : '' }} disabled> Não
                </td>
                <td>{{ $pack->price }}</td>
                <td>
                    <a href="{{ url('packs/' . $pack->id)  }}"><button type="button">Mostrar</button></a>
                        @can('update', $pack)
                        <a href="{{ url('packs/' . $pack->id) . '/edit' }}"><button type="button">Editar</button></a>
                        @endcan
                        @can('delete', $pack)
                        <form action="{{url('packs/' . $pack->id)}}" method="POST">
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
        {{ $packs->links() }}
    </div>

</div>
