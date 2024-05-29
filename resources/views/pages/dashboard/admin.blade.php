<x-app-layout>
    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold mb-5 text-gray-800 dark:text-gray-200">Bem-vindo {{ Auth::user()->firstLastName() }}</h1>

        <div class="py-12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mt-4">
                        <h3 class="text-xl font-medium mb-3">Estatísticas de Membros</h3>
                        <p class="mb-4">Novos membros: <span id="newMembersCount">{{ $newMembersMonthly }}</span></p>
                        <div class="flex justify-end mb-4">
                            <button id="togglePeriod" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-700 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold">
                                Vista Anual
                            </button>
                        </div>
                        <canvas id="membersChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var monthlyLabels = @json($monthlyLabels);
            var monthlyData = @json($monthlyData);
            var annualLabels = @json($annualLabels);
            var annualData = @json($annualData);

            function getChartColors() {
                var isDarkMode = document.documentElement.classList.contains('dark');
                return {
                    backgroundColor: isDarkMode ? 'rgba(124, 252, 0, 0.2)' : 'rgba(54, 162, 235, 0.2)',
                    borderColor: isDarkMode ? 'rgba(124, 252, 0, 1)' : 'rgba(54, 162, 235, 1)',
                };
            }

            var ctx = document.getElementById('membersChart').getContext('2d');
            var chartColors = getChartColors();
            var membersChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Novos Membros Diários',
                        data: monthlyData,
                        backgroundColor: chartColors.backgroundColor,
                        borderColor: chartColors.borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false // Ocultar a legenda para impedir deseleção
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            document.getElementById('togglePeriod').addEventListener('click', function() {
                var currentPeriod = membersChart.data.datasets[0].label;
                if (currentPeriod === 'Novos Membros Diários') {
                    membersChart.data.labels = annualLabels;
                    membersChart.data.datasets[0].data = annualData;
                    membersChart.data.datasets[0].label = 'Novos Membros Mensais';
                    document.getElementById('newMembersCount').innerText = '{{ $newMembersAnnually }}';
                    document.getElementById('togglePeriod').innerText = 'Vista Mensal';
                } else {
                    membersChart.data.labels = monthlyLabels;
                    membersChart.data.datasets[0].data = monthlyData;
                    membersChart.data.datasets[0].label = 'Novos Membros Diários';
                    document.getElementById('newMembersCount').innerText = '{{ $newMembersMonthly }}';
                    document.getElementById('togglePeriod').innerText = 'Vista Anual';
                }
                membersChart.update();
            });

            function updateChartColors() {
                chartColors = getChartColors();
                membersChart.data.datasets[0].backgroundColor = chartColors.backgroundColor;
                membersChart.data.datasets[0].borderColor = chartColors.borderColor;
                membersChart.update();
            }

            var observer = new MutationObserver(updateChartColors);
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        });
    </script>
</x-app-layout>
