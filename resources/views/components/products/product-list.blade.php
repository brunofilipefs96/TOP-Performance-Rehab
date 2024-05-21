
<div class="container mt-5">
    <h1>Lista de Produtos</h1>
    @can('create', App\Models\Product::class)
    <a href="{{ url('products/create') }}"><button type="button">Adicionar Produto</button></a>
    @endcan
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Preço</th>
            <th>Detalhes</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->image }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->details }}</td>
                <td>
                    <a href="{{ url('products/' . $product->id)  }}"><button type="button">Mostrar</button></a>
                        @can('update', $product)
                        <a href="{{ url('products/' . $product->id) . '/edit' }}"><button type="button">Editar</button></a>
                        @endcan
                        @can('delete', $product)
                        <form action="{{url('products/' . $product->id)}}" method="POST">
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
        {{ $products->links() }}
    </div>

</div>
