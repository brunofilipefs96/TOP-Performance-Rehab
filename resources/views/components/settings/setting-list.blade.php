<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Definições do Ginásio</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased dark:text-white/50 dark:bg-gray-800 select-none">
<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="{{ url()->previous() }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Definições do Ginásio</h1>
            </div>
            @if(session('success'))
                <div class="text-green-500 text-sm mb-5">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="taxa_inscricao" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Taxa de Inscrição</label>
                    <input type="text"
                           id="taxa_inscricao"
                           name="taxa_inscricao"
                           class="mt-1 block w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('taxa_inscricao', $settings['taxa_inscricao'] ?? '') }}"
                           aria-describedby="taxaInscricaoHelp">
                    @error('taxa_inscricao')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="taxa_seguro" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Taxa de Seguro</label>
                    <input type="text"
                           id="taxa_seguro"
                           name="taxa_seguro"
                           class="mt-1 block w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('taxa_seguro', $settings['taxa_seguro'] ?? '') }}"
                           aria-describedby="taxaSeguroHelp">
                    @error('taxa_seguro')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="capacidade_maxima" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Capacidade Máxima do Ginásio</label>
                    <input type="text"
                           id="capacidade_maxima"
                           name="capacidade_maxima"
                           class="mt-1 block w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('capacidade_maxima', $settings['capacidade_maxima'] ?? '') }}"
                           aria-describedby="capacidadeMaximaHelp">
                    @error('capacidade_maxima')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="percentagem_aulas_livres" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Percentagem de Aulas Livres (%)</label>
                    <input type="number"
                           id="percentagem_aulas_livres"
                           name="percentagem_aulas_livres"
                           min="0" max="100"
                           class="mt-1 block w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('percentagem_aulas_livres', $settings['percentagem_aulas_livres'] ?? '') }}"
                           aria-describedby="percentagemAulasLivresHelp">
                    @error('percentagem_aulas_livres')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="horario_inicio_semanal" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Horário de Início (Seg-Sex)</label>
                    <input type="text"
                           id="horario_inicio_semanal"
                           name="horario_inicio_semanal"
                           class="time-input mt-1 block w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('horario_inicio_semanal', $settings['horario_inicio_semanal'] ?? '') }}"
                           aria-describedby="horarioInicioSemanalHelp">
                    @error('horario_inicio_semanal')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="horario_fim_semanal" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Horário de Fim (Seg-Sex)</label>
                    <input type="text"
                           id="horario_fim_semanal"
                           name="horario_fim_semanal"
                           class="time-input mt-1 block w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('horario_fim_semanal', $settings['horario_fim_semanal'] ?? '') }}"
                           aria-describedby="horarioFimSemanalHelp">
                    @error('horario_fim_semanal')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="horario_inicio_sabado" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Horário de Início (Sábado)</label>
                    <input type="text"
                           id="horario_inicio_sabado"
                           name="horario_inicio_sabado"
                           class="time-input mt-1 block w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('horario_inicio_sabado', $settings['horario_inicio_sabado'] ?? '') }}"
                           aria-describedby="horarioInicioSabadoHelp">
                    @error('horario_inicio_sabado')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="horario_fim_sabado" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Horário de Fim (Sábado)</label>
                    <input type="text"
                           id="horario_fim_sabado"
                           name="horario_fim_sabado"
                           class="time-input mt-1 block w-full dark:border-gray-300  dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('horario_fim_sabado', $settings['horario_fim_sabado'] ?? '') }}"
                           aria-describedby="horarioFimSabadoHelp">
                    @error('horario_fim_sabado')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 mt-10">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('.time-input').on('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value.length >= 4) {
                value = value.slice(0, 2) + ':' + value.slice(2, 4);
            } else if (value.length >= 3) {
                value = value.slice(0, 2) + ':' + value.slice(2);
            }
            e.target.value = value;
        });
    });
</script>
</body>
</html>
