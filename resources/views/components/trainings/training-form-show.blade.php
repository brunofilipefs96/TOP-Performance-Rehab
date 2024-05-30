<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <div>
                <h1 class="mb-2 dark:text-lime-400 font-semibold text-gray-800">Treino {{$training->id}}</h1>
            </div>

            <div class="mb-4">
                <label for="name" class="block dark:text-white text-gray-800">Nome</label>
                <input type="text" value="{{$training->name}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="training_type" class="block dark:text-white text-gray-800">Tipo de Treino</label>
                <input type="text" value="{{$training->trainingType->name}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="room" class="block dark:text-white text-gray-800">Sala</label>
                <input type="text" value="{{$training->room->name}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="max_students" class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                <input type="number" value="{{$training->max_students}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="start_time" class="block dark:text-white text-gray-800">Início</label>
                <input type="text" value="{{$training->start_time}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="end_time" class="block dark:text-white text-gray-800">Término</label>
                <input type="text" value="{{$training->end_time}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            @if($training->personalTrainer)
                <div class="mb-4">
                    <label for="personal_trainer" class="block dark:text-white text-gray-800">Personal Trainer</label>
                    <input type="text" value="{{$training->personalTrainer->name}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
                </div>
            @endif

            <h2 class="mb-2 dark:text-lime-400 font-semibold text-gray-800">Participantes</h2>
            <ul class="list-disc list-inside dark:text-white text-gray-800">
                @foreach ($users as $user)
                    <li>{{ $user->name }} - Presença: {{ $user->pivot->presence ? 'Sim' : 'Não' }}</li>
                @endforeach
            </ul>

            @if(auth()->user()->can('enroll', $training))
                <form method="POST" action="{{ route('trainings.enroll', $training) }}" class="mt-6">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Inscrever-se</button>
                </form>
            @endif

            <div class="flex justify-center mt-6">
                <button onclick="history.back()" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-300 dark:hover:text-gray-800">Voltar</button>
            </div>
        </div>
    </div>
</div>
