<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <h1 class="font-bold">
                                <span class="text-white">ATEC</span>
                                <span class="text-lime-400">24</span>
                            </h1>

                        </div>
                        <?php if(Route::has('login')): ?>
                            <nav class="-mx-3 flex flex-1 justify-end">
                                <?php if(auth()->guard()->check()): ?>
                                    <a
                                        href="<?php echo e(url('/dashboard')); ?>"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                <?php else: ?>
                                    <a
                                        href="<?php echo e(route('login')); ?>"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Log in
                                    </a>

                                    <?php if(Route::has('register')): ?>
                                        <a
                                            href="<?php echo e(route('register')); ?>"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </nav>
                        <?php endif; ?>
                    </header>

                    <main class="mt-6 flex">
                        <div class="w-2/4">
                            <h1 class="text-6xl font-extrabold text-white pb-5">Welcome. If you already have account</h1>
                            <a href="<?php echo e(route('login')); ?>" class="inline-block bg-lime-400 hover:bg-lime-300 text-white font-bold py-2 px-6 rounded-full" type="button">Login</a>
                        </div>
                        <div class="w-2/4">

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
<?php /**PATH C:\Users\Bruno Silva\Documents\GitHub\TOP-Performance-Rehab\resources\views/welcome.blade.php ENDPATH**/ ?>