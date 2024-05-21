
<div class="container mt-5">
    <h1>Products List</h1>

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
                    @auth
                        <a href="{{ url('products/' . $product->id) . '/edit' }}"><button type="button">Editar</button></a>
                        <form action="{{url('products/' . $product->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                @endauth
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4 mb-3 pages">
        {{ $products->links() }}
    </div>

</div>
