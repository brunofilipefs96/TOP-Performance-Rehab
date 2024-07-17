@php
    use Carbon\Carbon;
    $startOfWeek = $selectedWeek->copy()->startOfWeek();
    $endOfWeek = $selectedWeek->copy()->endOfWeek();
    $currentDateTime = Carbon::now();
    $user = auth()->user();
@endphp

<div class="container mx-auto mt-10 mb-10">
    <h1 class="text-2xl mb-4 font-bold text-gray-800 dark:text-gray-200">Bem-vindo {{ Auth::user()->firstLastName() }}</h1>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Hora
                            </th>
                            @foreach (['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'] as $index => $day)
                                <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $day }}<br>{{ $startOfWeek->copy()->addDays($index)->format('d/m') }}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                        @for ($hour = 6; $hour <= 23; $hour++)
                            <tr>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                    {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                                </td>
                                @foreach (range(0, 6) as $day)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        @foreach ($trainings as $training)
                                            @php
                                                $startDateTime = Carbon::parse($training->start_date);
                                                $endDateTime = Carbon::parse($training->end_date);
                                            @endphp
                                            @if ($startDateTime->hour == $hour && $startDateTime->dayOfWeek == $day)
                                                <a href="{{ route('trainings.show', $training->id) }}" class="bg-blue-200 dark:bg-lime-500 rounded-lg p-1 text-center block border border-blue-300 dark:border-lime-300 hover:bg-blue-300 dark:hover:bg-lime-300">
                                                    <span class="block text-xs">{{ $training->trainingType->name }}</span>
                                                    <span class="block text-xs">{{ $startDateTime->format('H:i') }} - {{ $endDateTime->format('H:i') }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    </td>
                                @endforeach
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        openModal('Pretende eliminar?', 'Não poderá reverter isso!', `/trainings/${id}`, 'DELETE');
    }

    function cancelAction() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function closeMembershipModal() {
        document.getElementById('membership-modal').classList.add('hidden');
    }

    function confirmEnroll(id, button) {
        openModal('Pretende inscrever-se?', '', `/trainings/${id}/enroll`, 'POST');
    }

    function confirmCancel(id, button) {
        openModal('Pretende cancelar a inscrição?', '', `/trainings/${id}/cancel`, 'POST');
    }

    function disableConfirmButton(form) {
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin w-4 h-4 mr-2"></i> Processando...';
    }

    function openModal(title, message, actionUrl, method) {
        document.getElementById('confirmation-title').innerText = title;
        document.getElementById('confirmation-message').innerText = message;
        const confirmationForm = document.getElementById('confirmation-form');
        confirmationForm.action = actionUrl;
        confirmationForm.querySelector('input[name="_method"]').value = method;
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }
</script>
