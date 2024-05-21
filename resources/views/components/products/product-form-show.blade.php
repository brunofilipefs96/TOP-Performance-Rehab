<div class="container mt-5 glass pt-5">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="GET" action="{{ url('products') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <h1> Produto {{$product->id}}</h1>
                </div>
                <div>
                    <label for="name">Nome</label>
                    <input type="text" value="{{$product->name}}" disabled>
                    <small id="nameHelp" class="form-text text-muted">We'll never share your data with anyone
                        else.</small>
                </div>

                <div>
                    <label for="quantity">Quantidade</label>
                    <input class="form-control" type="number" value="{{$product->quantity}}" disabled>
                </div>

                <div>
                    <label for="price">Preço</label>
                    <input class="form-control" type="number" value="{{$product->price}}" disabled>
                </div>

                <div>
                    <label for="details">Detalhes</label>
                    <textarea class="form-control" type="text" value="{{$product->details}}" disabled></textarea>
                </div>

                <div>
                    <a href="/products" type="button"
                       >Voltar</a>
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>
