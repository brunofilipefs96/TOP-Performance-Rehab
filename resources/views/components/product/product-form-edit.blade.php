<div class="container mt-5 glass pt-5">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="POST" action="{{ url('products/' . $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-2">
                    <h1>Edit Product {{$product->id}}</h1>
                </div>

                <div class="form-group">
                    <label for="image">Imagem</label>
                    <input type="file"
                           id="image"
                           name="image"
                           autocomplete="image"
                           placeholder="Escolha a imagem"
                           class="form-control
                        @error('image') is-invalid @enderror"
                           value="{{ $product->iamge }}"

                           aria-describedby="nameHelp">
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text"
                           id="name"
                           name="name"
                           autocomplete="name"
                           placeholder="Insira o nome"
                           class="form-control
                        @error('name') is-invalid @enderror"
                           value="{{ $product->name }}"
                           required
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity">Quantidade</label>
                    <input type="text"
                           id="quantity"
                           name="quantity"
                           autocomplete="quantity"
                           placeholder="Insira a quantidade
                           class="form-control
                        @error('quantity') is-invalid @enderror"
                           value="{{ $product->quantity }}"
                           required
                           aria-describedby="nameHelp">
                    @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Preço</label>
                    <input type="number"
                           id="price"
                           name="price"
                           autocomplete="price"
                           placeholder="Insira o preço"
                           class="form-control
                        @error('price') is-invalid @enderror"
                           value="{{ $product->price }}"
                           required
                           aria-describedby="nameHelp">
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="details">Detalhes</label>
                    <textarea
                           id="details"
                           name="details"
                           autocomplete="details"
                           placeholder="Insira Detalhes"
                           class="form-control
                         @error('details') is-invalid @enderror"
                            required
                           aria-describedby="nameHelp">{{ $product->details }}
                    </textarea>
                    @error('details')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="mt-2 mb-5 btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>
