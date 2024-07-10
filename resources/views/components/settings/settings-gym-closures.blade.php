<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ url()->previous() }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Definições do Ginásio - Fechamentos</h1>
            </div>
            @if(session('success'))
                <div class="text-green-500 text-sm mb-5">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('settings.closures.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="closure_date" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data de Fechamento</label>
                    <input type="date"
                           id="closure_date"
                           name="closure_date"
                           class="mt-1 block w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('closure_date') }}"
                           aria-describedby="closureDateHelp">
                    @error('closure_date')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 mt-10">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm">Adicionar</button>
                </div>
            </form>
            <div class="mt-10">
                <h2 class="text-lg font-bold text-gray-800 dark:text-lime-400">Fechamentos Programados</h2>
                <ul class="mt-5">
                    @foreach ($closures as $closure)
                        <li class="flex justify-between items-center dark:text-gray-200 text-gray-800 mb-2">
                            <span>{{ $closure->closure_date }}</span>
                            <form method="POST" action="{{ route('settings.closures.destroy', $closure->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
