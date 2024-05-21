<div class="container mt-5 glass pt-5">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="GET" action="{{ url('training-types') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <h1> Tipo de treino {{$training_type->id}}</h1>
                </div>

                <div class="form-group">
                    @if ($training_type->image)
                        <img class="w-100 img-responsive" src="{{ asset('storage/'.$training_type->image) }}" alt="" title="">
                    @endif
                </div>

                <div>
                    <label for="name">Nome</label>
                    <input type="text" name="name" id="name" value="{{$training_type->name}}" disabled>
                </div>

                <div>
                    <a href="/training-types" type="button"
                    >Back</a>
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>
