<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden gap-4 md:-my-px md:ms-10 md:flex">
                    <x-nav-link :href="route('dashboard')" :activeRoutes="['dashboard']"
                                class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                        <i class="fa-solid fa-chart-line text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                        <span
                            class="absolute bottom-1 transform translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all">Dashboard</span>
                    </x-nav-link>

                    @if(Auth::check())
                        @if(Auth::user()->hasRole('admin'))
                            <x-nav-link :href="route('users.index')" :activeRoutes="['users.index']"
                                        class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                                <i class="fa-solid fa-users text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                                <span
                                    class="absolute bottom-1 transform translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all">Utilizadores</span>
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('personal_trainer'))
                            <!-- Dropdown for Products and Packs -->
                            <div
                                class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative"
                                x-data="{ dropdownOpen: false }" @mouseover="dropdownOpen = true"
                                @mouseout="dropdownOpen = false">
                                <x-nav-link :activeRoutes="['products.index', 'packs.index']"
                                            class="flex items-center justify-center space-x-2 focus:outline-none">
                                    <i class="fa-solid fa-basket-shopping text-xl transition-transform group-hover:-translate-y-1"></i>
                                </x-nav-link>
                                <div x-show="dropdownOpen"
                                     class="absolute mt-32 ml-32 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 z-50">
                                    <x-dropdown-link :href="route('products.index')"
                                                     :active="request()->routeIs('products.index')"
                                                     class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                        {{ __('Produtos') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('packs.index')"
                                                     :active="request()->routeIs('packs.index')"
                                                     class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                        {{ __('Packs') }}
                                    </x-dropdown-link>
                                </div>
                            </div>

                            <!-- Dropdown for Rooms and Trainings -->
                            <div
                                class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative"
                                x-data="{ dropdownOpen: false }" @mouseover="dropdownOpen = true"
                                @mouseout="dropdownOpen = false">
                                <x-nav-link :activeRoutes="['rooms.index', 'training-types.index', 'trainings.index']"
                                            class="flex items-center justify-center space-x-2">
                                    <i class="fa-solid fa-dumbbell text-xl transition-transform group-hover:-translate-y-1"></i>
                                </x-nav-link>
                                <div x-show="dropdownOpen"
                                     class="absolute mt-40 ml-32 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 z-50">
                                    <x-dropdown-link :href="route('rooms.index')"
                                                     :active="request()->routeIs('rooms.index')"
                                                     class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                        {{ __('Salas') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('training-types.index')"
                                                     :active="request()->routeIs('training-types.index')"
                                                     class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                        {{ __('Tipos de Treino') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('trainings.index')"
                                                     :active="request()->routeIs('trainings.index')"
                                                     class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                        {{ __('Treinos') }}
                                    </x-dropdown-link>
                                </div>
                            </div>

                        @elseif(Auth::user()->hasRole('client'))
                            <x-nav-link :href="route('products.index')" :activeRoutes="['products.index']"
                                        class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                                <i class="fa-solid fa-basket-shopping text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                                <span
                                    class="absolute bottom-1 transform translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all">Produtos</span>
                            </x-nav-link>
                            <x-nav-link :href="route('packs.index')" :activeRoutes="['packs.index']"
                                        class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                                <i class="fa-solid fa-box text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                                <span
                                    class="absolute bottom-1 transform translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all">Packs</span>
                            </x-nav-link>
                            <x-nav-link :href="route('trainings.index')" :activeRoutes="['trainings.index']"
                                        class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                                <i class="fa-solid fa-dumbbell text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                                <span
                                    class="absolute bottom-1 transform translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all">Treinos</span>
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('employee'))
                            <!-- Dropdown for Services, Memberships, and Insurances -->
                            <div
                                class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative"
                                x-data="{ dropdownOpen: false }" @mouseover="dropdownOpen = true"
                                @mouseout="dropdownOpen = false">
                                <x-nav-link :activeRoutes="['services.index', 'memberships.index', 'insurances.index']"
                                            class="flex items-center justify-center focus:outline-none">
                                    <i class="fa-solid fa-address-card text-xl transition-transform group-hover:-translate-y-1"></i>
                                </x-nav-link>
                                <div x-show="dropdownOpen"
                                     class="absolute mt-40 ml-32 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 z-50">
                                    <x-dropdown-link :href="route('services.index')"
                                                     :active="request()->routeIs('services.index')"
                                                     class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                        {{ __('Serviços') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('memberships.index')"
                                                     :active="request()->routeIs('memberships.index')"
                                                     class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                        {{ __('Matrículas') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('insurances.index')"
                                                     :active="request()->routeIs('insurances.index')"
                                                     class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                        {{ __('Seguros') }}
                                    </x-dropdown-link>
                                </div>
                            </div>
                        @endif
                    @endif

                    @php
                        $cart = session()->get('cart', []);
                        $packCart = session()->get('packCart', []);
                        $cartCount = count($cart) + count($packCart);
                    @endphp

                    <x-nav-link :href="route('cart.index')" :activeRoutes="['cart.index']"
                                class="group flex px-5 items-center justify-center text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                        <i class="fa-solid fa-cart-shopping text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                        <span
                            class="absolute bottom-1 transform translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all">Carrinho</span>
                        @if($cartCount > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-red-100 transform -translate-x-2 translate-y-2 bg-red-600 rounded-full">{{ $cartCount }}</span>
                        @endif
                    </x-nav-link>
                </div>
            </div>

            <!-- Theme Toggle Button -->
            <div class="flex items-center md:ms-6">
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

                <!-- Settings Dropdown -->
                <div class="hidden md:flex md:items-center md:ms-6">
                    <div x-data="{ dropdownOpen: false }" @mouseover="dropdownOpen = true" @mouseout="dropdownOpen = false" class="relative">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:outline-none transition ease-in-out duration-150">
                            <div>
                                <i class="fa-solid fa-user mr-2"></i>
                                {{ Auth::user()->firstLastName() }}
                            </div>
                        </button>
                        <div x-show="dropdownOpen" class="absolute right-0 mt-0 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 z-50" @mouseover="dropdownOpen = true" @mouseout="dropdownOpen = false">
                            <x-dropdown-link :href="route('profile.edit')"
                                             class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Hamburger and Cart for Mobile -->
                <div class="flex items-center md:hidden">
                    <x-nav-link :href="route('cart.index')" :activeRoutes="['cart.index']"
                                class="group flex px-5 items-center justify-center text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                        <i class="fa-solid fa-cart-shopping text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                        @if($cartCount > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-red-100 transform -translate-x-2 -translate-y-1 bg-red-600 rounded-full">{{ $cartCount }}</span>
                        @endif
                    </x-nav-link>
                    <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                   class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(Auth::check())
                @if(Auth::user()->hasRole('admin'))
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Users') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('products.index')"
                                           :active="request()->routeIs('products.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Produtos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Salas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('training-types.index')"
                                           :active="request()->routeIs('training-types.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Tipos de Treino') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('packs.index')" :active="request()->routeIs('packs.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Packs') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('trainings.index')"
                                           :active="request()->routeIs('trainings.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Treinos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('services.index')"
                                           :active="request()->routeIs('services.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Serviços') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('memberships.index')"
                                           :active="request()->routeIs('memberships.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Matrículas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('insurances.index')"
                                           :active="request()->routeIs('insurances.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Seguros') }}
                    </x-responsive-nav-link>
                @elseif(Auth::user()->hasRole('personal_trainer'))
                    <x-responsive-nav-link :href="route('products.index')"
                                           :active="request()->routeIs('products.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Produtos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Salas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('training-types.index')"
                                           :active="request()->routeIs('training-types.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Tipos de Treino') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('packs.index')" :active="request()->routeIs('packs.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Packs') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('trainings.index')"
                                           :active="request()->routeIs('trainings.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Treinos') }}
                    </x-responsive-nav-link>
                @elseif(Auth::user()->hasRole('client'))
                    <x-responsive-nav-link :href="route('products.index')"
                                           :active="request()->routeIs('products.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Produtos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('packs.index')" :active="request()->routeIs('packs.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Packs') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('trainings.index')"
                                           :active="request()->routeIs('trainings.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Treinos') }}
                    </x-responsive-nav-link>
                @elseif(Auth::user()->hasRole('employee'))
                    <x-responsive-nav-link :href="route('services.index')"
                                           :active="request()->routeIs('services.index')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                        {{ __('Serviços') }}
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div
                    class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->firstLastName() }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"
                                       class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
