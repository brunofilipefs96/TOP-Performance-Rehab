<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 text-white">Lista de Pacotes</h1>
    @can('create', App\Models\Pack::class)
        <a href="{{ url('packs/create') }}" class="block mb-4">
            <button type="button" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-700">Adicionar Pacote</button>
        </a>
    @endcan

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @foreach ($packs as $pack)
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md text-white">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $pack->name }}</h3>
                    <p class="text-gray-400 mb-2">Número de Treinos: {{ $pack->trainings_number }}</p>
                    <p class="text-gray-400 mb-2">
                        Personal Trainer:
                        <span>{{ $pack->has_personal_trainer ? 'Sim' : 'Não' }}</span>
                    </p>
                    <p class="text-gray-400 mb-2">{{ $pack->price }}</p>
                    <div class="flex justify-between items-center">
                        <a href="{{ url('packs/' . $pack->id) }}" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-700">Mostrar</a>
                        @can('update', $pack)
                            <a href="{{ url('packs/' . $pack->id . '/edit') }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-700">Editar</a>
                        @endcan
                        @can('delete', $pack)
                            <form action="{{url('packs/' . $pack->id)}}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-700">Eliminar</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-4 mb-3">
        {{ $packs->links() }}
    </div>
</div>
