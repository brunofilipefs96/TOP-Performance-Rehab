
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
                    <button class="btn btn-success">Mostrar</button>
                    <button class="btn btn-primary">Editar</button>
                    <button class="btn btn-danger">Eliminar</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
