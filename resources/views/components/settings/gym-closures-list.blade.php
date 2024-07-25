<div class="container mx-auto mt-10 mb-10">
    <div class="relative flex justify-center">
        <div class="absolute top-0 left-0">
            <a href="/settings" class="inline-block bg-gray-500 py-1 px-2 mt-4 ml-4 rounded-md shadow-sm hover:bg-gray-700 text-white">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
        <div class="w-full max-w-7xl bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm">
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Datas de Fecho</h1>
            </div>
            <div class="text-center mb-4">
                <p class="text-gray-600 dark:text-gray-300">Nesta página, pode definir os dias em que o ginásio estará fechado, incluindo domingos e feriados.</p>
            </div>
            <form method="POST" action="{{ route('settings.closures.update') }}" onsubmit="disableConfirmButton(this)">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach (range(1, 12) as $month)
                        @php
                            $firstDayOfMonth = new DateTime(date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01');
                            $dayOfWeek = $firstDayOfMonth->format('N');
                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
                            $monthName = [
                                1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                                5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                                9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                            ][$month];
                        @endphp
                        <div class="bg-gray-200 dark:bg-gray-700 p-4 rounded-lg shadow">
                            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-200">{{ $monthName }}</h2>
                            <div class="grid grid-cols-7 gap-2">
                                @foreach (['S', 'T', 'Q', 'Q', 'S', 'S', 'D'] as $dayName)
                                    <div class="text-center text-gray-600 dark:text-gray-400 day-name">{{ $dayName }}</div>
                                @endforeach
                                @for ($i = 1; $i < $dayOfWeek; $i++)
                                    <div class="empty-cell"></div>
                                @endfor
                                @foreach (range(1, $daysInMonth) as $day)
                                    @php
                                        $date = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                        $isClosed = in_array($date, $closures);
                                    @endphp
                                    <div class="cursor-pointer rounded-full day-circle {{ $isClosed ? 'bg-blue-500 dark:bg-lime-500 text-white dark:text-black' : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200' }}" data-date="{{ $date }}">
                                        {{ $day }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="closure_dates_container"></div>
                <div class="flex justify-end gap-2 mt-10">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-500 dark:text-gray-900 dark:hover:bg-lime-400">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const closureDates = @json($closures);
        const closureDatesContainer = document.getElementById('closure_dates_container');
        const closureElements = document.querySelectorAll('[data-date]');

        function updateClosureDates() {
            closureDatesContainer.innerHTML = '';
            closureDates.forEach(date => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'closure_dates[]';
                input.value = date;
                closureDatesContainer.appendChild(input);
            });
        }

        closureElements.forEach(el => {
            el.addEventListener('click', function() {
                const date = this.dataset.date;
                if (closureDates.includes(date)) {
                    closureDates.splice(closureDates.indexOf(date), 1);
                    this.classList.remove('bg-blue-500', 'dark:bg-lime-500', 'text-white', 'dark:text-black');
                    this.classList.add('bg-white', 'dark:bg-gray-800', 'text-gray-800', 'dark:text-gray-200');
                } else {
                    closureDates.push(date);
                    this.classList.add('bg-blue-500', 'dark:bg-lime-500', 'text-white', 'dark:text-black');
                    this.classList.remove('bg-white', 'dark:bg-gray-800', 'text-gray-800', 'dark:text-gray-200');
                }
                updateClosureDates();
            });
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            updateClosureDates();
        });

        updateClosureDates();
    });
</script>
