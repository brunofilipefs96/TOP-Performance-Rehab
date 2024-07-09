<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ginásio</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        #map {
            height: 400px; /* Adjust height as needed */
            width: 100%;
        }
    </style>
</head>
<body class="font-sans antialiased dark:text-white/50 select-none">
<div class="text-black/50 dark:text-white/50 dark:bg-gray-800">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white dark:bg-gray-900">

        <header class="flex justify-between items-center w-full px-6 py-4">
            <div class="text-center lg:text-left pl-2 pt-2">
                <h1 class="font-bold">
                    <span class="text-black dark:text-white font-semibold text-2xl">Ginásio</span>
                    <span class="text-blue-500 dark:text-lime-500 font-semibold text-2xl">TOP</span>
                </h1>
            </div>
            <div class="flex items-center space-x-4">
                <button id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 mr-3 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
                @if (Route::has('login'))
                    <nav class="flex space-x-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="rounded-md py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Entrar
                            </a>
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="rounded-md py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Registar
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <main class="mt-10 mb-20">
            <!-- Welcome Section -->
            <section class="text-center py-20 bg-gray-100 dark:bg-gray-800 relative h-96 rounded-2xl shadow-2xl">
                <div class="absolute inset-y-0 right-0 transform">
                    <img src="{{ asset('images/welcome.png') }}" alt="Imagem de boas-vindas" class="object-cover h-full w-full">
                </div>
                <div class="relative z-10">
                    <h1 class="text-5xl font-bold mb-4 dark:text-gray-200 text-gray-800">Sessão grátis com um treinador</h1>
                    <br>
                    <a href="{{ route('register') }}" class="bg-blue-500 text-white dark:bg-lime-400 dark:text-white py-2 px-4 rounded hover:bg-blue-400 dark:hover:bg-lime-300">Junte-se a nós</a>
                </div>
            </section>

            <!-- Reasons to Join Section -->
            <section class="py-20 text-center">
                <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Razões para se juntar</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">5000 sq.ft.</h3>
                        <p class="text-gray-700 dark:text-gray-300">Área para exercícios</p>
                    </div>
                    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Mais de 40+</h3>
                        <p class="text-gray-700 dark:text-gray-300">programas de treino em grupo</p>
                    </div>
                    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Zona Fitness</h3>
                        <p class="text-gray-700 dark:text-gray-300">Ciclismo indoor e zona de fitness</p>
                    </div>
                    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Treino Personalizado</h3>
                        <p class="text-gray-700 dark:text-gray-300">para todos os membros</p>
                    </div>
                </div>
            </section>

            <!-- Gym Membership Section -->
            <section class="py-20 text-center dark:bg-gray-900">
                <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Associação ao ginásio</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Plano 1</h3>
                        <p class="mb-4 text-gray-700 dark:text-gray-300">Descrição do plano básico</p>
                        <button class="bg-blue-500 text-white dark:bg-lime-400 dark:text-white py-2 px-4 rounded hover:bg-blue-400 dark:hover:bg-lime-300">Junte-se a nós</button>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Plano 2</h3>
                        <p class="mb-4 text-gray-700 dark:text-gray-300">Descrição do plano padrão</p>
                        <button class="bg-blue-500 text-white dark:bg-lime-400 dark:text-white py-2 px-4 rounded hover:bg-blue-400 dark:hover:bg-lime-300">Junte-se a nós</button>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Plano 3</h3>
                        <p class="mb-4 text-gray-700 dark:text-gray-300">Descrição do plano premium</p>
                        <button class="bg-blue-500 text-white dark:bg-lime-400 dark:text-white py-2 px-4 rounded hover:bg-blue-400 dark:hover:bg-lime-300">Junte-se a nós</button>
                    </div>
                </div>
            </section>

            <!-- About Us Section -->
            <section class="py-20 text-center bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl">
                <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Sobre nós</h2>
                <p class="mb-8 text-gray-700 dark:text-gray-300">Descrição sobre o ginásio, suas instalações e missão.</p>
                <img src="https://www.sorocaba.premiergym.com.br/img/servicos/capa/full-e4864124e4435ce0db29b8f573d13217.jpg" alt="Imagem do ginásio" class="mx-auto">
            </section>

            <!-- Map Section -->
            <section class="py-20 text-center">
                <h2 class="text-3xl font-bold mb-10 text-gray-900 dark:text-white">Contactos</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-100 p-5 rounded-2xl shadow-2xl dark:bg-gray-800">
                    <div class="space-y-4 text-left mt-20">
                        <p class="text-gray-900 dark:text-white">Telefone: 123-456-789</p>
                        <p class="text-gray-900 dark:text-white">E-mail: contacto@ginasiotop.com</p>
                        <p class="text-gray-900 dark:text-white">Endereço: Rua do Ginásio, 123, Famalicão, Portugal</p>
                    </div>
                    <div id="map" style="height: 300px;"></div>
                </div>
            </section>
        </main>
        <footer class="bg-gray-800 text-white p-4 w-full">
            @include('layouts.footer')
        </footer>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    (function() {
        function applyTheme(theme) {
            if (theme === "dark") {
                document.documentElement.classList.add("dark");
                document.getElementById("theme-toggle-dark-icon").classList.add("hidden");
                document.getElementById("theme-toggle-light-icon").classList.remove("hidden");
            } else {
                document.documentElement.classList.remove("dark");
                document.getElementById("theme-toggle-dark-icon").classList.remove("hidden");
                document.getElementById("theme-toggle-light-icon").classList.add("hidden");
            }
        }

        var savedTheme = localStorage.getItem("color-theme");
        if (savedTheme) {
            applyTheme(savedTheme);
        } else if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
            applyTheme("dark");
        } else {
            applyTheme("light");
        }
    })();

    // Initialize Leaflet map
    var map = L.map('map').setView([41.409073, -8.511614], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    L.marker([41.409073, -8.511614]).addTo(map)
        .bindPopup('Famalicão, Portugal')
        .openPopup();
</script>
</body>
</html>
