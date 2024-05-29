<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Verificar Email - Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased dark:text-white/50 select-none">
<div class="text-black/50 dark:text-white/50 dark:bg-gray-800">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-11/12 max-w-xl lg:max-w-6xl px-4 lg:px-12 shadow-2xl rounded-2xl mx-4 lg:mx-auto dark:bg-gray-900 bg-gray-100">
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
                </script>
            </header>

            <main class="mt-10 mb-20 flex flex-col items-center justify-center">
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between w-full max-w-md">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <x-primary-button>
                                {{ __('Resend Verification Email') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Log Out') }}
                        </button>
                    </form>
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
