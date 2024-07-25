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
<div class="container mx-auto mt-10 mb-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="absolute top-4 left-4">
                <a href="/dashboard" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Definições do Ginásio</h1>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-800 dark:text-gray-200">Preencha todas as informações das definições de ginásio para o site ficar ativo.</p>
            </div>
            <form method="POST" action="{{ route('settings.update') }}" onsubmit="disableConfirmButton(this)">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="taxa_inscricao" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Taxa de Inscrição</label>
                    <input type="text"
                           id="taxa_inscricao"
                           name="taxa_inscricao"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
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
                           class="time-input mt-1 block w-full dark:border-gray-300 dark:border-gray-700 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('horario_fim_sabado', $settings['horario_fim_sabado'] ?? '') }}"
                           aria-describedby="horarioFimSabadoHelp">
                    @error('horario_fim_sabado')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <hr class="my-6">

                <div class="mb-4">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-lime-400 text-center">Descontos por Tipo de Cliente</h2>
                </div>

                <div class="mb-4">
                    <label class="block text-md font-medium dark:text-gray-200 text-gray-800">Clientes TOP Padel</label>
                </div>
                <div class="mb-4">
                    <label for="top_paddle_client_membership_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto na Taxa de Inscrição (%)</label>
                    <input type="text"
                           id="top_paddle_client_membership_discount"
                           name="top_paddle_client_membership_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_client_membership_discount', $settings['top_paddle_client_membership_discount'] ?? '') }}">
                    @error('top_paddle_client_membership_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="top_paddle_client_insurance_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto na Taxa de Seguro (%)</label>
                    <input type="text"
                           id="top_paddle_client_insurance_discount"
                           name="top_paddle_client_insurance_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_client_insurance_discount', $settings['top_paddle_client_insurance_discount'] ?? '') }}">
                    @error('top_paddle_client_insurance_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="top_paddle_client_trainings_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto nos Treinos (%)</label>
                    <input type="text"
                           id="top_paddle_client_trainings_discount"
                           name="top_paddle_client_trainings_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_client_trainings_discount', $settings['top_paddle_client_trainings_discount'] ?? '') }}">
                    @error('top_paddle_client_trainings_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4 mt-10">
                    <label class="block text-md font-medium dark:text-gray-200 text-gray-800">Funcionários TOP Padel</label>
                </div>
                <div class="mb-4">
                    <label for="top_paddle_employee_membership_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto na Taxa de Inscrição (%)</label>
                    <input type="text"
                           id="top_paddle_employee_membership_discount"
                           name="top_paddle_employee_membership_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_employee_membership_discount', $settings['top_paddle_employee_membership_discount'] ?? '') }}">
                    @error('top_paddle_employee_membership_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="top_paddle_employee_insurance_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto na Taxa de Seguro (%)</label>
                    <input type="text"
                           id="top_paddle_employee_insurance_discount"
                           name="top_paddle_employee_insurance_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_employee_insurance_discount', $settings['top_paddle_employee_insurance_discount'] ?? '') }}">
                    @error('top_paddle_employee_insurance_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="top_paddle_employee_funcional_training_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto nos Treinos Funcionais (%)</label>
                    <input type="text"
                           id="top_paddle_employee_funcional_training_discount"
                           name="top_paddle_employee_funcional_training_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_employee_funcional_training_discount', $settings['top_paddle_employee_funcional_training_discount'] ?? '') }}">
                    @error('top_paddle_employee_funcional_training_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="top_paddle_employee_personal_training_trainings_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto nos Treinos Personalizados (%)</label>
                    <input type="text"
                           id="top_paddle_employee_personal_training_trainings_discount"
                           name="top_paddle_employee_personal_training_trainings_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_employee_personal_training_trainings_discount', $settings['top_paddle_employee_personal_training_trainings_discount'] ?? '') }}">
                    @error('top_paddle_employee_personal_training_trainings_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4 mt-10">
                    <label class="block text-md font-medium dark:text-gray-200 text-gray-800">Administradores TOP Padel</label>
                </div>

                <div class="mb-4">
                    <label for="top_paddle_admin_membership_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto na Taxa de Inscrição (%)</label>
                    <input type="text"
                           id="top_paddle_admin_membership_discount"
                           name="top_paddle_admin_membership_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_admin_membership_discount', $settings['top_paddle_admin_membership_discount'] ?? '') }}">
                    @error('top_paddle_admin_membership_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="top_paddle_admin_insurance_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto na Taxa de Seguro (%)</label>
                    <input type="text"
                           id="top_paddle_admin_insurance_discount"
                           name="top_paddle_admin_insurance_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_admin_insurance_discount', $settings['top_paddle_admin_insurance_discount'] ?? '') }}">
                    @error('top_paddle_admin_insurance_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="top_paddle_admin_funcional_training_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto nos Treinos Funcionais (%)</label>
                    <input type="text"
                           id="top_paddle_admin_funcional_training_discount"
                           name="top_paddle_admin_funcional_training_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_admin_funcional_training_discount', $settings['top_paddle_admin_funcional_training_discount'] ?? '') }}">
                    @error('top_paddle_admin_funcional_training_discount')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="top_paddle_admin_personal_training_trainings_discount" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Desconto nos Treinos Personalizados (%)</label>
                    <input type="text"
                           id="top_paddle_admin_personal_training_trainings_discount"
                           name="top_paddle_admin_personal_training_trainings_discount"
                           class="mt-1 block w-full dark:border-gray-300 dark:bg-gray-400 text-gray-800 dark:focus:border-lime-600 focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm"
                           value="{{ old('top_paddle_admin_personal_training_trainings_discount', $settings['top_paddle_admin_personal_training_trainings_discount'] ?? '') }}">
                    @error('top_paddle_admin_personal_training_trainings_discount')
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

    <!-- New Container for Closure Dates -->
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-lime-400">Datas de Fecho</h2>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-800 dark:text-gray-200">Utilize o botão abaixo para definir os dias em que o ginásio se encontra fechado.</p>
            </div>
            <div class="mb-4">
                <a href="{{ route('settings.closures') }}" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm block text-center">Definir Datas de Fecho</a>
            </div>
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
