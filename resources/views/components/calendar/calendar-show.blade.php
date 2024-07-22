@php
    use Carbon\Carbon;
    $startOfWeek = $selectedWeek->copy()->startOfWeek(Carbon::SUNDAY);
    $endOfWeek = $selectedWeek->copy()->endOfWeek(Carbon::SATURDAY);
    $currentDateTime = Carbon::now();
    $user = auth()->user();
@endphp

<div class="container mx-auto mt-10 mb-10 px-4">
    <h1 class="text-2xl mb-4 font-bold text-gray-800 dark:text-gray-200">A Sua Agenda</h1>

    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg max-w-full px-4">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="mb-10">
                <h3 class="text-2xl font-medium mb-3 text-center">Calendário Semanal</h3>
                <div class="flex justify-center items-center mb-4">
                    @if ($selectedWeek->gt($currentWeek) || auth()->user()->hasRole('admin'))
                        <form method="POST" action="{{ route('dashboard.changeWeek') }}" class="mr-2">
                            @csrf
                            <input type="hidden" name="direction" value="previous">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-900 font-bold py-2 px-4 rounded">
                                <<
                            </button>
                        </form>
                    @endif
                    <div class="mx-4 text-lg font-semibold">
                        {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M') }}
                    </div>
                    @if ($selectedWeek->lt($currentWeek->copy()->addWeeks(2)) || !auth()->user()->hasRole('client'))
                        <form method="POST" action="{{ route('dashboard.changeWeek') }}" class="ml-2">
                            @csrf
                            <input type="hidden" name="direction" value="next">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-900 font-bold py-2 px-4 rounded">
                                >>
                            </button>
                        </form>
                    @endif
                </div>
                <div class="flex justify-center items-center mb-6">
                    <h3 class="text-lg font-medium mb-3 text-center">{{ date('Y') }}</h3>
                </div>
                <div class="overflow-x-auto w-full">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden border-gray-200 dark:border-gray-700 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead>
                                <tr>
                                    <th class="bg-gray-300 dark:bg-gray-700 p-2 text-center font-bold border border-gray-400">Dia da Semana</th>
                                    <th class="bg-gray-300 dark:bg-gray-700 p-2 text-center font-bold border border-gray-400">Treinos</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach (['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'] as $index => $day)
                                    @php
                                        $currentDay = $startOfWeek->copy()->addDays($index);
                                        $dayTrainings = $trainings->filter(function ($training) use ($currentDay) {
                                            $startDateTime = Carbon::parse($training->start_date);
                                            return $startDateTime->isSameDay($currentDay);
                                        });
                                        $dayFreeTrainings = $freeTrainings->filter(function ($freeTraining) use ($currentDay) {
                                            $startDateTime = Carbon::parse($freeTraining->start_date);
                                            return $startDateTime->isSameDay($currentDay);
                                        });
                                    @endphp
                                    <tr>
                                        <td class="bg-gray-200 dark:bg-gray-600 text-center p-2 whitespace-nowrap border border-gray-400">{{ $day }} ({{ $currentDay->format('d M') }})</td>
                                        <td class="p-2 bg-gray-100 dark:bg-gray-500 border border-gray-400">
                                            @if ($dayTrainings->isEmpty() && $dayFreeTrainings->isEmpty())
                                                <span class="block text-xs text-center">Sem treinos</span>
                                            @else
                                                @foreach ($dayTrainings as $training)
                                                    @php
                                                        $startDateTime = Carbon::parse($training->start_date);
                                                        $endDateTime = Carbon::parse($training->end_date);
                                                    @endphp
                                                    <a href="{{ route('trainings.show', $training->id) }}" class="bg-blue-200 dark:bg-lime-500 rounded-lg p-1 text-center block border border-blue-300 dark:border-lime-300 hover:bg-blue-300 dark:hover:bg-lime-300 mb-2">
                                                        <span class="block text-xs font-bold">{{ $training->trainingType->name }}</span>
                                                        <span class="block text-xs">{{ $startDateTime->format('H:i') }} - {{ $endDateTime->format('H:i') }}</span>
                                                    </a>
                                                @endforeach
                                                @foreach ($dayFreeTrainings as $freeTraining)
                                                    @php
                                                        $startDateTime = Carbon::parse($freeTraining->start_date);
                                                        $endDateTime = Carbon::parse($freeTraining->end_date);
                                                    @endphp
                                                    <div class="bg-green-200 dark:bg-lime-700 rounded-lg p-1 text-center block border border-green-300 dark:border-lime-400 mb-2">
                                                        <span class="block text-xs font-bold">{{ $freeTraining->name }}</span>
                                                        <span class="block text-xs">{{ $startDateTime->format('H:i') }} - {{ $endDateTime->format('H:i') }}</span>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
