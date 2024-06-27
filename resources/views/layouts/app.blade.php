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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-100 dark:bg-gray-900">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @if(auth()->user()->hasRole('client'))
        <div class="flex">
            @include('layouts.client-navigation')
            <div class="flex-1">
                <!-- Page Content -->
                <main class="p-4">
                    {{ $slot }}
                    <div id="success-modal" class="fixed top-20 right-5 flex items-center justify-center bg-opacity-75 hidden">
                        <div class="bg-blue-300 p-4 rounded-md shadow-md w-64 dark:bg-lime-500">
                            <h2 class="text-base font-bold mb-2 dark:text-white text-gray-800">Ação bem-sucedida!</h2>
                            <p class="text-sm mb-2 dark:text-white text-gray-800">A ação foi realizada com sucesso.</p>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    @else
        @include('layouts.navigation')
        <!-- Page Content -->
        <main class="p-4">
            {{ $slot }}
            <div id="success-modal" class="fixed top-20 right-5 flex items-center justify-center bg-opacity-75 hidden">
                <div class="bg-blue-300 p-4 rounded-md shadow-md w-64 dark:bg-lime-500">
                    <h2 class="text-base font-bold mb-2 dark:text-white text-gray-800">Ação bem-sucedida!</h2>
                    <p class="text-sm mb-2 dark:text-white text-gray-800">A ação foi realizada com sucesso.</p>
                </div>
            </div>
        </main>
    @endif
</div>

<script>
    (function () {
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
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        themeToggleBtn.addEventListener('click', () => {
            const isDarkMode = document.documentElement.classList.toggle('dark');
            if (isDarkMode) {
                themeToggleDarkIcon.classList.add('hidden');
                themeToggleLightIcon.classList.remove('hidden');
                localStorage.setItem('color-theme', 'dark');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleLightIcon.classList.add('hidden');
                localStorage.setItem('color-theme', 'light');
            }
        });
    });
</script>
</body>
<footer class="text-center text-sm text-black dark:text-white/70 dark:bg-gray-800 bg-gray-50">
    <div class="dark:text-white text-gray-400 p-6">
        <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-semibold mb-4">Apoio ao Cliente </h3>
                <div class="flex justify-center items-center mb-4">
                    <a href="{{ route('faq.index') }}"
                       class="hover:underline dark:hover:text-lime-400 hover:text-blue-500">Perguntas Frequentes</a>
                </div>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-4 pr-20">Opening Hours</h3>
                <ul class="space-y-2 text-gray-400 text-start">
                    <li>Monday ---------------------------- 10 AM - 05 PM</li>
                    <li>Tuesday ---------------------------- 10 AM - 05 PM</li>
                    <li>Wednesday ------------------------ 10 AM - 05 PM</li>
                    <li>Thursday --------------------------- 10 AM - 05 PM</li>
                    <li>Friday ------------------------------ 10 AM - 02 PM</li>
                    <li>Saturday --------------------------- 10 AM - 12 PM</li>
                    <li>Sunday ----------------------------- Closed</li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-4">Get in Touch</h3>
                <p class="text-gray-400 mb-2">
                    <strong>Address:</strong> 8953 South Gainsway Avenue Park Ridge, IL 60068
                </p>
                <p class="text-gray-400 mb-2">
                    <strong>Phone:</strong> +91 345-677-554, +22 333-444-555
                </p>
                <p class="text-gray-400 mb-4">
                    <strong>Email:</strong> info@sitename.com
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-google-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="mt-8 pt-4">
            <div class="max-w-screen-xl mx-auto flex justify-center items-center text-gray-400 text-sm">
                <p>2024 © Ginásio TOP Performance & Rehab</p>
            </div>
        </div>
    </div>
</footer>
</html>
