<div class="container mt-5 glass pt-5">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="POST" action="{{ url('packs/' . $pack->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-2">
                    <h1>Editar Pacote {{$pack->id}}</h1>
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
                           value="{{ $pack->name }}"
                           required
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="has_personal_trainer">Personal Trainer</label>
                    <div>
                        <input type="radio" id="personal_trainer_yes" name="has_personal_trainer" value="1" {{ $pack->has_personal_trainer ? 'checked' : '' }}>
                        <label for="personal_trainer_yes">Sim</label>
                    </div>
                    <div>
                        <input type="radio" id="personal_trainer_no" name="has_personal_trainer" value="0" {{ !$pack->has_personal_trainer ? 'checked' : '' }}>
                        <label for="personal_trainer_no">Não</label>
                    </div>
                    @error('has_personal_trainer')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="trainings_number">Numero de Treinos</label>
                    <input type="number"
                           id="trainings_number"
                           name="trainings_number"
                           autocomplete="trainings_number"
                           placeholder="Insira a quantidade de treinos"
                           class="form-control
                        @error('trainings_number') is-invalid @enderror"
                           value="{{ $pack->trainings_number }}"
                           required
                           aria-describedby="nameHelp">
                    @error('trainings_number')
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
                           value="{{ $pack->price }}"
                           required
                           aria-describedby="nameHelp">
                    @error('price')
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
