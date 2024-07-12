<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-100 dark:bg-gray-900 select-none">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col relative">
    @if(auth()->user()->hasRole('client'))
        <div class="flex ">
            <div class="">
                @include('layouts.client-navigation')
            </div>
            <div class="flex-1 flex flex-col">
                <!-- Page Content -->
                <main class="p-4 pt-0 flex-1 min-h-screen">
                    <div class="sticky py-4 top-0 z-30 flex justify-start align-middle h-[82px] w-full text-center bg-gray-900 sm:hidden">
                        <h1 class="font-bold content-center text-3xl">
                            <a href="{{ route('dashboard') }}">
                                <span class="text-black dark:text-white">Ginásio</span>
                                <span class="text-blue-500 dark:text-lime-500">TOP</span>
                            </a>
                        </h1>
                    </div>
                    {{ $slot }}
                    <div id="success-modal"
                         class="fixed top-20 right-5 flex items-center justify-center bg-opacity-75 hidden">
                        <div class="bg-blue-300 p-4 rounded-md shadow-md w-64 dark:bg-lime-500">
                            <h2 class="text-base font-bold mb-2 dark:text-white text-gray-800">Ação bem-sucedida!</h2>
                            <p class="text-sm mb-2 dark:text-white text-gray-800">A ação foi realizada com sucesso.</p>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    <div >
        @include('layouts.client-footer')
    </div>
    @else
        <div class="flex-1 flex flex-col">
            @include('layouts.navigation')
            <!-- Page Content -->
            <main class="p-4 flex-1">

                {{ $slot }}
                <div id="success-modal" class="fixed top-20 right-5 flex items-center justify-center bg-opacity-75 hidden">
                    <div class="bg-blue-300 p-4 rounded-md shadow-md w-64 dark:bg-lime-500">
                        <h2 class="text-base font-bold mb-2 dark:text-white text-gray-800">Ação bem-sucedida!</h2>
                        <p class="text-sm mb-2 dark:text-white text-gray-800">A ação foi realizada com sucesso.</p>
                    </div>
                </div>
            </main>
            <footer>
                @include('layouts.footer')
            </footer>
        </div>
    @endif
</div>

<script>
    (function () {
        function applyTheme(theme) {
            if (theme === "dark") {
                document.documentElement.classList.add("dark");
                document.querySelectorAll('.theme-toggle-dark-icon').forEach(icon => icon.classList.add('hidden'));
                document.querySelectorAll('.theme-toggle-light-icon').forEach(icon => icon.classList.remove('hidden'));
            } else {
                document.documentElement.classList.remove("dark");
                document.querySelectorAll('.theme-toggle-dark-icon').forEach(icon => icon.classList.remove('hidden'));
                document.querySelectorAll('.theme-toggle-light-icon').forEach(icon => icon.classList.add('hidden'));
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

    document.addEventListener('DOMContentLoaded', function () {
        var successInfo = @json(session('success', false));
        if (successInfo) {
            const successModal = document.getElementById('success-modal');
            successModal.classList.remove('hidden');
            setTimeout(function () {
                successModal.classList.add('fade-out');
            }, 1500);

            setTimeout(function () {
                successModal.classList.add('hidden');
            }, 2500);
        }

        // Theme toggle
        const themeToggleBtns = document.querySelectorAll('.theme-toggle-btn');
        themeToggleBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const isDarkMode = document.documentElement.classList.toggle('dark');
                if (isDarkMode) {
                    document.querySelectorAll('.theme-toggle-dark-icon').forEach(icon => icon.classList.add('hidden'));
                    document.querySelectorAll('.theme-toggle-light-icon').forEach(icon => icon.classList.remove('hidden'));
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.querySelectorAll('.theme-toggle-dark-icon').forEach(icon => icon.classList.remove('hidden'));
                    document.querySelectorAll('.theme-toggle-light-icon').forEach(icon => icon.classList.add('hidden'));
                    localStorage.setItem('color-theme', 'light');
                }
            });
        });
    });
</script>
</body>
</html>
