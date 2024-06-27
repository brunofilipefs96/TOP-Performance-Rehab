<div class="container mx-auto">
    <h1 class="text-2xl mb-4 font-bold text-gray-800 dark:text-gray-200">Bem-vindo {{ Auth::user()->firstLastName() }}</h1>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="mb-10">
                <h3 class="text-2xl font-medium mb-3 text-center">Calendário Semanal</h3>
                <div class="flex justify-center items-center mb-4">
                    <form method="POST" action="{{ route('dashboard.changeWeek') }}" class="mr-2">
                        @csrf
                        <input type="hidden" name="direction" value="previous">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-900 font-bold py-2 px-4 rounded">
                            <<
                        </button>
                    </form>
                    <!-- Display current week range -->
                    <div class="mx-4 text-lg font-semibold">
                        {{ \Carbon\Carbon::parse($startOfWeek)->format('d M') }} - {{ \Carbon\Carbon::parse($startOfWeek)->addDays(6)->format('d M') }}
                    </div>
                    <form method="POST" action="{{ route('dashboard.changeWeek') }}" class="ml-2">
                        @csrf
                        <input type="hidden" name="direction" value="next">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-900 font-bold py-2 px-4 rounded">
                            >>
                        </button>
                    </form>
                </div>
                <div class="flex justify-center items-center mb-6">
                    <h3 class="text-lg font-medium mb-3 text-center">{{ date('Y') }}</h3>
                </div>
                <div class="flex justify-center">
                    <div class="max-w-7xl w-full">
                        <!-- Wrapper for scrolling -->
                        <div class="overflow-x-auto">
                            <div class="min-w-max lg:min-w-0">
                                <div class="grid grid-cols-8 text-xs font-medium text-gray-700 dark:text-gray-300 rounded-t-lg">
                                    <div class="bg-gray-300 dark:bg-gray-700 p-2 text-center rounded-tl-lg border-r">Hora</div>
                                    @foreach (['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'] as $index => $day)
                                        <div class="bg-blue-500 dark:bg-lime-500 text-white p-2 text-center border-l {{ $index == 6 ? 'rounded-tr-lg' : '' }}">
                                            {{ $day }} {{ \Carbon\Carbon::parse($startOfWeek)->addDays($index)->format('d/m') }}
                                        </div>
                                    @endforeach
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    @for ($hour = 6; $hour <= 23; $hour++)
                                        <div class="grid grid-cols-8 border-b">
                                            <div class="bg-gray-200 dark:bg-gray-600 text-center p-2 border-r">{{ $hour }}:00</div>
                                            @for ($day = 0; $day < 7; $day++)
                                                <div class="p-2 bg-gray-100 dark:bg-gray-500 border-l">
                                                    @foreach ($trainings as $training)
                                                        @php
                                                            $startDateTime = \Carbon\Carbon::parse($training->start_date);
                                                            $endDateTime = \Carbon\Carbon::parse($training->end_date);
                                                        @endphp
                                                        @if ($startDateTime->hour == $hour && $startDateTime->dayOfWeek == $day)
                                                            <a href="{{ route('trainings.show', $training->id) }}" class="bg-blue-200 dark:bg-lime-500 rounded-lg p-1 text-center block border border-blue-300 dark:border-lime-300 hover:bg-blue-300 dark:hover:bg-lime-300">
                                                                <span class="block text-xs">{{ $training->trainingType->name }}</span>
                                                                <span class="block text-xs">{{ $startDateTime->format('H:i') }} - {{ $endDateTime->format('H:i') }}</span>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endfor
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
