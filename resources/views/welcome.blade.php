<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased dark:text-white/50 select-none">
<div class="bg-gray-300 text-black/50 dark:text-white/50 dark:bg-gray-800">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-xl lg:max-w-6xl px-4 lg:px-6 shadow-2xl rounded-2xl mx-4 lg:mx-auto dark:bg-gray-900 bg-gray-100">
            <header class="grid grid-cols-1 lg:grid-cols-3 items-center gap-2 py-10">
                <div class="text-center lg:text-left">
                    <h1 class="font-bold">
                        <span class="text-black dark:text-white font-semibold">ATEC</span>
                        <span class="text-lime-500 dark:text-lime-500 font-semibold">24</span>
                    </h1>
                </div>
                <div class="col-span-2 flex justify-center lg:justify-end">
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
                                    class="rounded-md  py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Entrar
                                </a>
                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="rounded-md  py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Registar
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </header>

            <main class="mt-10 mb-20 flex flex-col-reverse lg:flex-row items-center lg:items-start">
                <div class="lg:w-1/2 mt-10 pt-20 lg:pl-20 text-center lg:text-left">
                    <h1 class="text-3xl lg:text-6xl font-extrabold dark:text-white text-gray-700 pb-5">Bem-vindo!</h1>
                    <h3 class="text-xl lg:text-3xl font-extrabold dark:text-white text-gray-600 pb-5">Se ainda não és nosso Cliente</h3>
                    <a href="{{ route('register') }}" class="inline-block bg-lime-400 hover:bg-lime-300 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-white font-bold py-4 px-10 rounded-full" type="button">Começa já</a>
                </div>
                <div class="lg:w-1/2 mt-10 lg:mt-0 flex items-center justify-center">
                    <img src="{{ asset('images/welcome.jpg') }}" alt="Descrição da imagem" class="w-48 h-48 lg:w-96 lg:h-96 transition duration-500 ease-in-out rounded-2xl transform hover:scale-105">
                </div>
            </main>

            <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                2024 © TOP Performance & Rehab
            </footer>
        </div>
    </div>
</div>
</body>
</html>
