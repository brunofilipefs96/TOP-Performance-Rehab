@php
    $user = Auth::user();
@endphp

<div x-data="{ open: false }" @keydown.window.escape="open = false" class="relative h-full">
    <div class="flex h-full min-h-screen">
        <div class="w-64 dark:bg-gray-800 bg-gray-600 shadow h-full flex-col justify-between hidden sm:flex">
            <div class="px-8">
                <div class="h-40 w-full flex items-center mt-8 mb-16">
                    <div class="w-full flex flex-col items-center">
                        <h1 class="font-bold text-2xl mb-4 mt-8">
                            <a href="{{ route('dashboard') }}">
                            <span class="text-black dark:text-white">Ginásio</span>
                            <span class="text-blue-500 dark:text-lime-500">TOP</span>
                            </a>

                        </h1>
                        @if($user->image && file_exists(public_path('storage/' . $user->image)))
                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->firstLastName() }}" class="h-32 w-32 object-cover rounded-full border-2 border-gray-300">
                        @else
                            <div class="h-32 w-32 bg-gray-300 dark:bg-gray-600 flex items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-600">
                                <i class="fa-solid fa-user text-4xl text-gray-800 dark:text-white"></i>
                                <a class="cursor-pointer"><i class="fa-solid fa-circle-plus text-2xl"></i></a>
                            </div>
                        @endif
                        <span class="flex flex-col mt-2 content-center">
                            <span class="text-lg text-gray-300">{{$user->full_name}}</span>
                        </span>
                    </div>
                </div>
                <ul class="flex-1">
                    <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                        <a href="{{ route('dashboard') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                            <i class="fa-solid fa-chart-line text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                            <span class="text-md ml-2">Dashboard</span>
                        </a>
                    </li>
                    <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                        <a href="{{ route('profile.edit') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                            <i class="fa-solid fa-user text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                            <span class="text-md ml-2">Perfil</span>
                        </a>
                    </li>
                    <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                        <a href="{{ route('products.index') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                            <i class="fa-solid fa-basket-shopping text-xl transition-transform group-hover:-translate-y-1"></i>
                            <span class="text-md ml-2">Produtos</span>
                        </a>
                    </li>
                    <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                        <a href="{{ route('packs.index') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                            <i class="fa-solid fa-box text-xl transition-transform group-hover:-translate-y-1"></i>
                            <span class="text-md ml-2">Packs</span>
                        </a>
                    </li>
                    <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                        <a href="{{ route('sales.index') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                            <i class="fa-solid fa-receipt text-xl transition-transform group-hover:-translate-y-1"></i>
                            <span class="text-md ml-2">Minhas Encomendas</span>
                        </a>
                    </li>
                    <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                        <a href="{{ route('trainings.index') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                            <i class="fa-solid fa-dumbbell text-xl transition-transform group-hover:-translate-y-1"></i>
                            <span class="text-md ml-2">Treinos</span>
                        </a>
                    </li>
                    <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                        <a href="{{ route('calendar') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                            <i class="fa-solid fa-calendar-days text-xl transition-transform group-hover:-translate-y-1"></i>
                            <span class="text-md ml-2">Agenda</span>
                        </a>
                    </li>
                    <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                        <a href="{{ route('cart.index') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                            <i class="fa-solid fa-cart-shopping text-xl transition-transform group-hover:-translate-y-1"></i>
                            <span class="text-md ml-2">Carrinho</span>
                        </a>
                    </li>
                </ul>
                <div class="mt-auto mb-6">
                    <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center dark:hover:text-lime-400 hover:text-blue-600">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <a href="javascript:void(0)" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa-solid fa-right-from-bracket text-2xl transition-transform group-hover:-translate-y-1"></i>
                                <span class="text-md ml-2">Sair</span>
                            </a>
                        </form>
                    </li>
                </div>
                <div class="flex justify-center">
                    <button id="theme-toggle-client" type="button"
                            class="theme-toggle-btn w-12 text-gray-300 dark:text-gray-400 hover:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-700 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon-client" class="theme-toggle-dark-icon hidden w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon-client" class="theme-toggle-light-icon hidden w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-full" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-full" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 sm:hidden">
            <div @click.away="open = false" class="bg-white dark:bg-gray-800 w-full h-full shadow-lg flex flex-col">
                <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="font-bold text-2xl">
                        <a href="{{ route('dashboard') }}">
                            <span class="text-black dark:text-white">Ginásio</span>
                            <span class="text-blue-500 dark:text-lime-500">TOP</span>
                        </a>
                    </h1>
                    <button @click="open = false" class="text-gray-600 dark:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <ul class="space-y-4 p-4">
                        <li><a href="{{ route('dashboard') }}" class="block text-gray-800 dark:text-gray-200">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="block text-gray-800 dark:text-gray-200">Perfil</a></li>
                        <li><a href="{{ route('products.index') }}" class="block text-gray-800 dark:text-gray-200">Produtos</a></li>
                        <li><a href="{{ route('packs.index') }}" class="block text-gray-800 dark:text-gray-200">Packs</a></li>
                        <li><a href="{{ route('sales.index') }}" class="block text-gray-800 dark:text-gray-200">Minhas Encomendas</a></li>
                        <li><a href="{{ route('calendar') }}" class="block text-gray-800 dark:text-gray-200">Agenda</a></li>
                        <li><a href="{{ route('trainings.index') }}" class="block text-gray-800 dark:text-gray-200">Treinos</a></li>
                        <li><a href="{{ route('cart.index') }}" class="block text-gray-800 dark:text-gray-200">Carrinho</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="javascript:void(0)" class="block text-gray-800 dark:text-gray-200" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Sair
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- Theme Toggle Button -->
                <div class="p-2 flex justify-center mb-5">
                    <button id="theme-toggle-client" type="button"
                            class="theme-toggle-btn w-12 text-gray-500 dark:text-gray-400 hover:bg-gray-700 hover:text-gray-200 dark:hover:bg-gray-700 focus:outline-none  dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon-client" class="theme-toggle-dark-icon hidden w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon-client" class="theme-toggle-light-icon hidden w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Floating Button -->
        <button @click="open = true" x-show="!open" class="fixed top-4 right-4 z-50 bg-blue-500 dark:bg-lime-500 text-white rounded-full p-4 shadow-lg sm:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
</div>
