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

    <style>
        .fade-out {
            transition: opacity 0.5s ease-in-out;
            opacity: 0;
        }

        .success-modal-content {
            display: flex;
            align-items: center;
            background-color: #529af4; /* Tailwind blue-300 */
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .success-modal-content.dark {
            background-color: #A3E635; /* Tailwind lime-500 */
        }

        .success-modal-content i {
            font-size: 2rem;
            color: white;
            margin-right: 0.75rem;
        }

        .success-modal-text h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.25rem;
        }

        .success-modal-text p {
            font-size: 0.875rem;
            color: white;
        }
    </style>
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
                    <div class="w-full sticky py-4 top-0 z-30 flex justify-start align-middle h-[82px] text-center bg-gray-100 dark:bg-gray-900 sm:hidden">
                        <h1 class="font-bold content-center text-3xl">
                            <a href="{{ route('dashboard') }}">
                                <span class="text-black dark:text-white">Ginásio</span>
                                <span class="text-blue-500 dark:text-lime-500">TOP</span>
                            </a>
                        </h1>
                    </div>
                    {{ $slot }}
                    <div id="success-modal"
                         class="fixed top-20 right-5 hidden z-50">
                        <div class="success-modal-content">
                            <i class="fa-solid fa-check-circle"></i>
                            <div class="success-modal-text">
                                <h2>Ação bem-sucedida!</h2>
                                <p>A ação foi realizada com sucesso.</p>
                            </div>
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
                <div id="success-modal" class="fixed top-20 right-5 hidden z-50">
                    <div class="success-modal-content">
                        <i class="fa-solid fa-check-circle"></i>
                        <div class="success-modal-text">
                            <h2>Ação bem-sucedida!</h2>
                            <p>A ação foi realizada com sucesso.</p>
                        </div>
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
            const successModal = document.querySelector('.success-modal-content');
            if (theme === "dark") {
                document.documentElement.classList.add("dark");
                document.querySelectorAll('.theme-toggle-dark-icon').forEach(icon => icon.classList.add('hidden'));
                document.querySelectorAll('.theme-toggle-light-icon').forEach(icon => icon.classList.remove('hidden'));
                successModal.classList.add('dark');
            } else {
                document.documentElement.classList.remove("dark");
                document.querySelectorAll('.theme-toggle-dark-icon').forEach(icon => icon.classList.remove('hidden'));
                document.querySelectorAll('.theme-toggle-light-icon').forEach(icon => icon.classList.add('hidden'));
                successModal.classList.remove('dark');
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
                successModal.classList.remove('fade-out');
            }, 2000);
        }

        // Theme toggle
        const themeToggleBtns = document.querySelectorAll('.theme-toggle-btn');
        themeToggleBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const isDarkMode = document.documentElement.classList.toggle('dark');
                const successModal = document.querySelector('.success-modal-content');
                if (isDarkMode) {
                    document.querySelectorAll('.theme-toggle-dark-icon').forEach(icon => icon.classList.add('hidden'));
                    document.querySelectorAll('.theme-toggle-light-icon').forEach(icon => icon.classList.remove('hidden'));
                    localStorage.setItem('color-theme', 'dark');
                    successModal.classList.add('dark');
                } else {
                    document.querySelectorAll('.theme-toggle-dark-icon').forEach(icon => icon.classList.remove('hidden'));
                    document.querySelectorAll('.theme-toggle-light-icon').forEach(icon => icon.classList.add('hidden'));
                    localStorage.setItem('color-theme', 'light');
                    successModal.classList.remove('dark');
                }
            });
        });
    });

    function disableConfirmButton(form) {
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin w-4 h-4 mr-2"></i> Aguarde...';
    }
</script>
</body>
</html>
