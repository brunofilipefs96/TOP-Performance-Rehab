<div class="container mt-5 glass pt-5">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="POST" action="{{ url('rooms/' . $room->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-2">
                    <h1>Editar Sala {{$room->id}}</h1>
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
                           value="{{ $room->name }}"
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="capacity">Capacidade</label>
                    <input type="number"
                           id="capacity"
                           name="capacity"
                           autocomplete="capacity"
                           placeholder="Insira a capacidade"
                           class="form-control
                        @error('capacity') is-invalid @enderror"
                           value="{{ $room->capacity }}"
                           required
                           aria-describedby="nameHelp">
                    @error('capacity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="mt-2 mb-5 btn btn-primary">Submeter</button>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>
