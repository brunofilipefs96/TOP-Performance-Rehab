<div class="container mt-5 glass pt-5">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="GET" action="{{ url('rooms') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <h1>Sala {{$room->id}}</h1>
                </div>

                <div>
                    <label for="name">Nome</label>
                    <input type="text" value="{{$room->name}}" disabled>
                    <small id="nameHelp" class="form-text text-muted">We'll never share your data with anyone
                        else.</small>
                </div>

                <div>
                    <label for="capacity">Capacidade</label>
                    <input class="form-control" type="number" value="{{$room->capacity}}" disabled>
                </div>

                <div>
                    <a href="/rooms" type="button"
                       >Voltar</a>
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>
