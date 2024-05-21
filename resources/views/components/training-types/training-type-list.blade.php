
<div class="container mt-5">
    <h1>Tipos de Treino</h1>
    @can('create', App\Models\TrainingType::class)
        <a href="{{ url('training-types/create') }}"><button type="button">Adicionar tipo de treino</button></a>
    @endcan
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($training_types as $training_type)
            <tr>
                <td>{{ $training_type->id }}</td>
                <td>{{ $training_type->name }}</td>
                <td>{{ $training_type->image }}</td>
                <td>
                    <a href="{{ url('training-types/' . $training_type->id)  }}"><button type="button">Mostrar</button></a>
                    @can('update', $training_type)
                        <a href="{{ url('training-types/' . $training_type->id) . '/edit' }}"><button type="button">Editar</button></a>
                    @endcan
                    @can('delete',$training_type)
                        <form action="{{url('training-types/' . $training_type->id)}}" method="POST">
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
        {{ $training_types->links() }}
    </div>

</div>
