<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased text-gray-100 dark:bg-gray-900">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')
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

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="px-10 py-5">
                {{ $slot }}
                <div id="success-modal" class="fixed top-20 right-5 flex items-center justify-center bg-opacity-75 hidden">
                    <div class="bg-blue-300 p-4 rounded-md shadow-md w-64 dark:bg-lime-500">
                        <h2 class="text-base font-bold mb-2 dark:text-white text-gray-800">Ação bem-sucedida!</h2>
                        <p class="text-sm mb-2 dark:text-white text-gray-800">A ação foi realizada com sucesso.</p>
                    </div>
                </div>
            </main>
        </div>

        <script>
            // Modal de atualização com sucesso
            document.addEventListener('DOMContentLoaded', function() {
                // Verifique se há uma mensagem de sucesso na sessão
                @if(session('success'))
                document.getElementById('success-modal').classList.remove('hidden');
                // Esconder o modal após 5 segundos
                setTimeout(hideSuccessModal, 5000);
                @endif
            });

            // Seleciona o modal de sucesso
            const successModal = document.getElementById('success-modal');

            // Função para esconder o modal
            function hideSuccessModal() {
                successModal.classList.add('hidden');
            }

            // Função para recarregar a página
            function reloadPage() {
                location.reload();
            }

            // Observa mudanças na classe do modal de sucesso
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        const currentClassState = mutation.target.classList.contains('hidden');
                        if (currentClassState) {
                            reloadPage();
                        }
                    }
                });
            });

            // Configurar o observador para observar mudanças na classe do modal de sucesso
            observer.observe(successModal, {
                attributes: true // Configurar para observar mudanças em atributos
            });
        </script>

    </body>
    <footer class="py-16 text-center text-sm text-black dark:text-white/70 dark:bg-gray-900">
        2024 © TOP Performance & Rehab
    </footer>
</html>
