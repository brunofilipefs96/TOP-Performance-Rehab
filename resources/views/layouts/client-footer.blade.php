<footer class="text-center text-sm text-black dark:text-white dark:bg-gray-800 bg-gray-600 p-4 py-8">
        <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">Apoio ao Cliente</h3>
                <div class="flex justify-center items-center mb-4">
                    <a href="{{ route('faq.index') }}"
                       class="text-white hover:underline dark:hover:text-lime-400 hover:text-blue-500">Perguntas Frequentes</a>
                </div>
            </div>
            <div>
                <h3 class="text-xl text-center font-bold mb-4">Horário de Funcionamento</h3>
                <ul class="space-y-2 text-gray-200 ">
                    <li>Seg a sex --------------- {{ setting('horario_inicio_semanal') }} às {{ setting('horario_fim_semanal') }} </li>
                    <li>Sáb --------------------- {{ setting('horario_inicio_sabado') }} às {{ setting('horario_fim_sabado') }} </li>
                    <li>Dom -------------------------- Fechado</li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-4">Fale conosco</h3>
                <p class="text-gray-200 mb-2">
                    <strong>Morada:</strong> 8953 South Gainsway Avenue Park Ridge, IL 60068
                </p>
                <p class="text-gray-200 mb-2">
                    <strong>Telefone:</strong> {{ setting('telemovel') }}
                </p>
                <p class="text-gray-200 mb-4">
                    <strong>E-mail:</strong> {{ setting('email') }}
                </p>
                <div class="flex justify-center space-x-4 text-xl text-white">
                    <a href="#" class="dark:hover:text-lime-400 hover:text-blue-500"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="dark:hover:text-lime-400 hover:text-blue-500"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="dark:hover:text-lime-400 hover:text-blue-500"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="dark:hover:text-lime-400 hover:text-blue-500"><i class="fab fa-google-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="mt-8 pt-4">
            <div class="max-w-screen-xl mx-auto flex flex-col justify-center items-center dark:text-gray-400 text-white text-sm">
                <p>2024 © Ginásio TOP Performance & Rehab </p>
                <h1>Developed by Team One</h1>
            </div>
        </div>
    </div>
</footer>
