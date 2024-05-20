<div class="container mt-5 glass pt-5">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="POST" action="{{ url('products') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <h1>Add Product</h1>
                    <hr>
                </div>
                <div class="form-group">
                    <label for="image">Imagem</label>
                    <input type="file"
                           id="image"
                           name="image"
                           autocomplete="image"
                           placeholder="Coloque a imagem"
                           class="form-control
                        @error('image') is-invalid @enderror"
                           value="{{ old('image') }}"
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
                           placeholder="Escreva o nome"
                           class="form-control
                        @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
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
                    <input type="number"
                           id="quantity"
                           name="quantity"
                           autocomplete="quantity"
                           placeholder="Insira a quantidade"
                           class="form-control
                        @error('quantity') is-invalid @enderror"
                           value="{{ old('quantity') }}"
                           required
                           aria-describedby="nameHelp">
                    @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number"
                           id="price"
                           name="price"
                           autocomplete="price"
                           placeholder="Type the Price"
                           class="form-control
                        @error('name') is-invalid @enderror"
                           value="{{ old('price') }}"
                           required
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="details">Detalhes</label>
                    <input type="text"
                           id="details"
                           name="details"
                           autocomplete="details"
                           placeholder="Insira detalhes"
                           class="form-control
                        @error('details') is-invalid @enderror"
                           value="{{ old('details') }}"
                           required
                           aria-describedby="nameHelp">
                    @error('details')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <button type="submit" class="mt-4 mb-5 btn btn-primary">Add</button>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>


