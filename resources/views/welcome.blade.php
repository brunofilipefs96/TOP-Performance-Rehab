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
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            margin: 0 auto;
            padding: 0 20px;
            max-width: 1200px;
        }

        #map {
            height: 400px; /* Adjust height as needed */
            width: 100%;
        }

        .welcome-section {
            background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            position: relative;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 15px; /* Rounded corners for the welcome section */
            overflow: hidden;
            margin: 20px 0;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3); /* Dark overlay for better text readability */
            z-index: 1;
        }

        .welcome-section .content {
            position: relative;
            z-index: 2;
            color: white;
            padding: 20px;
            border-radius: 10px;
        }

        .welcome-section .content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: inherit;
        }

        .welcome-section .content a {
            display: inline-block;
            color: white;
            padding: 1rem 2rem;
            border-radius: 30px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .welcome-section .content a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

    </style>
</head>
<body class="font-sans antialiased dark:text-white/50 select-none dark:bg-gray-800">
<div class="text-black/50 dark:text-white/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white dark:bg-gray-900">

        <header class="flex justify-between items-center w-full px-6 py-2 container">
            <div class="text-center lg:text-left pl-2 pt-2">
                <h1 class="font-bold">
                    <span class="text-black dark:text-white font-semibold text-2xl">Ginásio</span>
                    <span class="text-blue-500 dark:text-lime-500 font-semibold text-2xl">TOP</span>
                </h1>
            </div>
            <div class="flex items-center space-x-4 py-4">
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

        <main class="mt-10 mb-20 container">
            <!-- Welcome Section -->
            <section class="welcome-section">
                <div class="content">
                    <h1 class="text-5xl font-bold mb-4">Sessão grátis com um treinador</h1>
                    <a href="{{ route('register') }}" class="dark:bg-lime-400 dark:hover:bg-lime-300 bg-blue-500 hover:bg-blue-400">Junte-se a nós</a>
                </div>
            </section>

            <!-- Reasons to Join Section -->
            <section class="py-20 text-center">
                <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Razões para se juntar</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Um Espaço à Medida</h3>
                        <p class="text-gray-700 dark:text-gray-300">para os seus exercícios</p>
                    </div>
                    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Mais de 10+</h3>
                        <p class="text-gray-700 dark:text-gray-300">programas de treino em grupo</p>
                    </div>
                    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Zona Fitness</h3>
                        <p class="text-gray-700 dark:text-gray-300">Áreas de Pilates e Treino Funcional</p>
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
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Pack PT Individual</h3>
                        <p class="mb-4 text-gray-700 dark:text-gray-300">Para um acompanhamento mais personalizado.</p>
                        <button class="bg-blue-500 text-white dark:bg-lime-400 dark:text-white py-2 px-4 rounded hover:bg-blue-400 dark:hover:bg-lime-300">Junte-se a nós</button>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Pack Treino Livre</h3>
                        <p class="mb-4 text-gray-700 dark:text-gray-300">Para os membros mais experientes.</p>
                        <button class="bg-blue-500 text-white dark:bg-lime-400 dark:text-white py-2 px-4 rounded hover:bg-blue-400 dark:hover:bg-lime-300">Junte-se a nós</button>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-2xl shadow-2xl">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Packs Duo/Trio</h3>
                        <p class="mb-4 text-gray-700 dark:text-gray-300">Para quem gosta de grupos maiores.</p>
                        <button class="bg-blue-500 text-white dark:bg-lime-400 dark:text-white py-2 px-4 rounded hover:bg-blue-400 dark:hover:bg-lime-300">Junte-se a nós</button>
                    </div>
                </div>
            </section>

            <!-- About Us Section -->
            <section class="py-20 text-center bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-2xl">
                <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Sobre nós</h2>
                <p class="mb-8 text-gray-700 dark:text-gray-300">No Ginásio TOP, oferecemos instalações sofisticadas e uma equipa dedicada para ajudar a alcançar seus objetivos. A nossa missão é proporcionar um ambiente acolhedor e motivador para todos os nossos membros.</p>
                <p class="mb-8 text-gray-700 dark:text-gray-300 italic font-semibold">"O treino de hoje é o resultado de amanhã."</p>
                <img src="https://www.sorocaba.premiergym.com.br/img/servicos/capa/full-e4864124e4435ce0db29b8f573d13217.jpg" alt="Imagem do ginásio" class="mx-auto rounded-lg shadow-lg">
            </section>

            <!-- Map Section -->
            <section class="py-20 text-center">
                <h2 class="text-3xl font-bold mb-10 text-gray-900 dark:text-white">Contactos</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-100 p-5 rounded-2xl shadow-2xl dark:bg-gray-800">
                    <div class="space-y-4 text-left mt-20">
                        <p class="text-gray-900 dark:text-white">Telemóvel: {{ setting('telemovel') }}</p>
                        <p class="text-gray-900 dark:text-white">E-mail: {{ setting('email') }}</p>
                        <p class="text-gray-900 dark:text-white">Endereço: R. do Outeiro 121, 4770-452 Requião</p>
                    </div>
                    <div id="map" style="height: 300px;"></div>
                </div>
            </section>
        </main>

        <footer class="w-full">
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
