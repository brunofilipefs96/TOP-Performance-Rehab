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
<body class="font-sans antialiased dark:bg-black dark:text-white/50 select-none">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white bg-gray-300">
        <div class="relative w-full max-w-xl lg:max-w-6xl px-4 lg:px-6 bg-black shadow-2xl rounded-2xl mx-4 lg:mx-auto">
            <header class="grid grid-cols-1 lg:grid-cols-3 items-center gap-2 py-10">
                <div class="text-center lg:text-left">
                    <h1 class="font-bold">
                        <span class="text-white">ATEC</span>
                        <span class="text-lime-400">24</span>
                    </h1>
                </div>
                <div class="col-span-2 flex justify-center lg:justify-end">
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
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Entrar
                                </a>
                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
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
                    <h1 class="text-3xl lg:text-6xl font-extrabold text-white pb-5">Bem-vindo!</h1>
                    <h3 class="text-xl lg:text-3xl font-extrabold text-white pb-5">Se ainda não és nosso Cliente</h3>
                    <a href="{{ route('register') }}" class="inline-block bg-lime-400 hover:bg-lime-300 text-white font-bold py-4 px-10 rounded-full" type="button">Começa já</a>
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
