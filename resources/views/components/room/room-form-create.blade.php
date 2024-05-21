<div class="container mt-5 glass pt-5">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="POST" action="{{ url('rooms') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <h1>Adicionar Sala</h1>
                    <hr>
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
                           value="{{ old('name') }}"
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="capacity">Capaciddade</label>
                    <input type="number"
                           id="capacity"
                           name="capacity"
                           autocomplete="capacity"
                           placeholder="Insira a capacidade"
                           class="form-control
                        @error('capacity') is-invalid @enderror"
                           value="{{ old('capacity') }}"
                           required
                           aria-describedby="nameHelp">
                    @error('capacity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="mt-4 mb-5 btn btn-primary">Adicionar</button>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>


