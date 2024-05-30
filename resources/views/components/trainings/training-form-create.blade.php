<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <div>
                <h1 class="mb-2 dark:text-lime-400 font-semibold text-gray-800">Criar Treino</h1>
            </div>
            @if ($trainingTypes->isEmpty() || $rooms->isEmpty())
                <div class="mb-4 dark:text-white text-gray-800">
                    <p class="mb-2">Para criar um treino, você precisa adicionar pelo menos um tipo de treino e uma sala.</p>
                    @if ($trainingTypes->isEmpty())
                        <a href="{{ route('training_types.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Adicionar Tipo de Treino</a>
                    @endif
                    @if ($rooms->isEmpty())
                        <a href="{{ route('rooms.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Adicionar Sala</a>
                    @endif
                </div>
            @else
                <form method="POST" action="{{ route('trainings.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block dark:text-white text-gray-800">Nome</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label for="training_type_id" class="block dark:text-white text-gray-800">Tipo de Treino</label>
                        <select name="training_type_id" id="training_type_id" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                            @foreach ($trainingTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="room_id" class="block dark:text-white text-gray-800">Sala</label>
                        <select name="room_id" id="room_id" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="max_students" class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                        <input type="number" name="max_students" id="max_students" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label for="start_time" class="block dark:text-white text-gray-800">Início</label>
                        <input type="datetime-local" name="start_time" id="start_time" step="600" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label for="end_time" class="block dark:text-white text-gray-800">Término</label>
                        <input type="datetime-local" name="end_time" id="end_time" step="600" required class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Criar Treino</button>
                </form>
            @endif
        </div>
    </div>
</div>
