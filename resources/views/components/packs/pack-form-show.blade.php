<div class="container mt-5 glass pt-5">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="GET" action="{{ url('packs') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <h1> Pacote {{$pack->id}}</h1>
                </div>
                <div>
                    <label for="name">Nome</label>
                    <input type="text" value="{{ $pack->name }}" disabled>
                    <small id="nameHelp" class="form-text text-muted">We'll never share your data with anyone
                        else.</small>
                </div>

                <div>
                    <label for="trainings_number">Numero de Treinos </label>
                    <input class="form-control" type="text" value="{{ $pack->trainings_number }}" disabled>
                </div>

                <div>
                    <label for="has_personal_trainer">Personal Trainer</label>
                    <div>
                        <input type="radio" name="has_personal_trainer" value="1" {{ $pack->has_personal_trainer ? 'checked' : '' }} disabled> Sim
                        <input type="radio" name="has_personal_trainer" value="0" {{ !$pack->has_personal_trainer ? 'checked' : '' }} disabled> Não
                    </div>
                </div>

                <div>
                    <label for="price">Preço</label>
                    <input class="form-control" type="number" value="{{ $pack->price }}" disabled>
                </div>

                <div>
                    <a href="/packs" type="button"
                       >Voltar</a>
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>
