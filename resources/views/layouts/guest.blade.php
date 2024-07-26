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
<body class="font-sans text-gray-900 antialiased select-none">

<div class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-0 bg-gray-100 dark:bg-gray-300">
    <div class="w-full m:max-w-lg px-6 shadow-md overflow-hidden dark:bg-gray-800">
        {{ $slot }}
    </div>
</div>
</body>
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

    function disableConfirmButton(form) {
        const button = form.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin w-4 h-4 mr-2"></i>Aguarde...';

        setTimeout(() => {
            button.disabled = false;
            button.innerHTML = originalText;
        }, 2000);
    }
</script>
</html>
