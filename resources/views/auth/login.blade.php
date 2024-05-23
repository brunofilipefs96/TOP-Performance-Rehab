<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white dark:bg-gray-900 p-8 rounded-lg shadow-md space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900 dark:text-white">
                    {{ __('Entrar') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    {{ __('ou') }}
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 dark:text-lime-400 hover:text-indigo-500 dark:hover:text-lime-300">{{ __('Criar uma Conta.') }}</a>
                </p>
            </div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>
                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-lime-600 shadow-sm focus:ring-lime-500 dark:focus:ring-lime-600 dark:focus:ring-offset-lime-800" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Lembrar Password') }}</span>
                    </label>
                </div>
                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                            {{ __('Esqueceu-se da sua Password?') }}
                        </a>
                    @endif
                    <x-primary-button class="ms-3 dark:bg-lime-400 hover:dark:bg-lime-300">
                        {{ __('Entrar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
