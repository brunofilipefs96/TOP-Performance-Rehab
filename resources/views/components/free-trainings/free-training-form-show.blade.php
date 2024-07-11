@php
    use Carbon\Carbon;
@endphp

<div class="container mx-auto mt-10 mb-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('free-trainings.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="mt-10 text-center">
                <h1 class="mb-6 dark:text-lime-400 font-semibold text-gray-800">{{ $freeTraining->name }}</h1>
            </div>
            <div class="mb-4">
                <label class="block dark:text-white text-gray-800">Máximo de Alunos</label>
                <p class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:bg-gray-600 dark:text-white">{{ $freeTraining->max_students }}</p>
            </div>
            <div class="mb-4">
                <label class="block dark:text-white text-gray-800">Data e Hora de Início</label>
                <p class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:bg-gray-600 dark:text-white">{{ Carbon::parse($freeTraining->start_date)->format('d/m/Y H:i') }}</p>
            </div>
            <div class="mb-4">
                <label class="block dark:text-white text-gray-800">Data e Hora de Término</label>
                <p class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:bg-gray-600 dark:text-white">{{ Carbon::parse($freeTraining->end_date)->format('d/m/Y H:i') }}</p>
            </div>
            <div class="mb-4">
                <label class="block dark:text-white text-gray-800">Inscrições</label>
                <ul class="list-disc list-inside mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:bg-gray-600 dark:text-white">
                    @foreach ($freeTraining->users as $user)
                        <li>{{ $user->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
