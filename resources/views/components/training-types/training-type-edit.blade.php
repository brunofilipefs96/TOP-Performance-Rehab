<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div class="flex justify-center mb-5">
                <h1 class="text-xl font-bold text-gray-200 dark:text-lime-400">Editar Tipo de Treino</h1>
            </div>
            <div>
                <h1 class="mb-6 dark:text-lime-200 font-semibold">{{$training_type->name}}</h1>
            </div>
            <form method="POST" id="update-form" action="{{ url('training-types/' . $training_type->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-200">Imagem</label>
                    <input type="file"
                           id="image"
                           name="image"
                           autocomplete="image"
                           placeholder="Escolha a imagem"
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('image') border-red-500 @enderror dark:bg-gray-600 dark:text-white"
                           value="{{ $training_type->image }}"
                           aria-describedby="imageHelp">
                    @error('image')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-200">Nome</label>
                    <input type="text"
                           id="name"
                           name="name"
                           autocomplete="name"
                           placeholder="Insira o nome"
                           class="mt-1 block w-full p-2 border border-gray-600 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                           @error('name') border-red-500 @enderror dark:bg-gray-600 dark:text-white dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
                           value="{{ $training_type->name }}"
                           required
                           aria-describedby="nameHelp">
                    @error('name')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900" onclick="confirmarAtualizacao()">Atualizar</button>
                    <button type="button" onclick="history.back()" class="bg-gray-500 mt-4 mb-5 py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 dark:bg-gray-500 dark:hover:bg-gray-400">Cancelar</button>
                </div>
            </form>
            <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                <div class="bg-white p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                    <h2 class="text-xl font-bold mb-4">Pretende atualizar?</h2>
                    <p class="mb-4 text-lime-200">Poderá reverter isso!</p>
                    <div class="flex justify-end gap-4">
                        <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                        <button id="confirm-button" class="bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-lime-400">Atualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmarAtualizacao() {
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-button').addEventListener('click', function() {
        document.getElementById('update-form').submit();
    });
</script>
