<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    @if ($user->gender == 'male')
                        <div class="text-3xl font-bold mb-4">
                            Bem vindo,
                            <br>
                            <span class="text-blue-500 dark:text-lime-500">{{ Auth::user()->full_name }}</span>!
                        </div>
                    @elseif ($user->gender == 'female')
                        <div class="text-3xl font-bold mb-4">
                            Bem vinda,
                            <br>
                            <span class="text-blue-500 dark:text-lime-500">{{ Auth::user()->full_name }}</span>!
                        </div>
                    @else
                        <div class="text-3xl font-bold mb-4">
                            Bem vind@,
                            <br>
                            <span class="text-blue-500 dark:text-lime-500">{{ Auth::user()->full_name }}</span>!
                        </div>
                    @endif

                    <p class="text-lg">Os alunos estão à sua espera! Aqui pode ver os treinos que tem agendados ou agendar novos treinos.</p>

                    <hr class="my-6 border-gray-400 dark:border-gray-600">

                    @if (!$hasTrainings)
                        <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-6 mb-6 rounded-lg shadow-lg" role="alert">
                            <p class="font-bold text-lg">Ainda não tem treinos agendados</p>
                            <p class="mt-2">Gostaria de marcar treinos? Clique no botão abaixo para agendar agora!</p>
                            <a href="{{ route('trainings.create') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-6 py-3 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400 transition-all">Agendar Treino</a>
                        </div>
                    @else
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-4">Treinos Agendados:</h3>
                            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($trainings as $training)
                                    <a href="{{ route('trainings.show', $training->id) }}" class="block bg-gradient-to-r from-blue-300 to-blue-600 dark:from-lime-200 dark:to-lime-600 p-1 rounded-lg shadow-md transition-transform transform hover:scale-105">
                                        <div class="bg-gray-200 dark:bg-gray-700 p-6 rounded-lg">
                                            <div class="flex justify-between items-center mb-4">
                                                <h4 class="text-xl font-bold text-blue-500 dark:text-lime-500">{{ $training->trainingType->name }}</h4>
                                                <i class="fa-solid fa-dumbbell text-2xl text-blue-500 dark:text-lime-500"></i>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-semibold">Sala:</span> {{ $training->room->name }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-semibold">Dia:</span> {{ \Carbon\Carbon::parse($training->start_date)->format('d/m/Y') }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-semibold">Hora:</span> {{ \Carbon\Carbon::parse($training->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($training->end_date)->format('H:i') }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $trainings->links() }} <!-- Links de paginação -->
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
