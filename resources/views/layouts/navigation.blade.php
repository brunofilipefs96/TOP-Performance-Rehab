@php
    $user = Auth::user();
    $unreadNotificationsCount = $user->notifications()->whereNull('read_at')->count();
    $recentNotifications = $user->notifications()
        ->with('notificationType')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
@endphp

<nav x-data="{ open: false, notificationOpen: false }"
     class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <h1 class="font-bold content-center text-xl sm:text-2xl">
                        <a href="{{ route('dashboard') }}">
                            <span class="text-black dark:text-white">Ginásio</span>
                            <span class="text-blue-500 dark:text-lime-500">TOP</span>
                        </a>
                    </h1>
                </div>

                <!-- Navigation Links -->
                <div class="hidden gap-4 md:-my-px md:ms-10 lg:flex">
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
                        @elseif (Auth::user()->hasRole('personal_trainer'))
                            <x-nav-link :href="route('memberships.index')" :activeRoutes="['memberships.index']"
                                        class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                                <i class="fa-solid fa-users text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                                <span
                                    class="absolute bottom-1 transform translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all">Clientes</span>
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
                                     class="absolute mt-40 ml-32 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 z-50">
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
                                    <x-dropdown-link :href="route('sales.index')"
                                                     :active="request()->routeIs('sales.index')"
                                                     class="dropdown-link text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                                        {{ __('Vendas') }}
                                    </x-dropdown-link>
                                </div>
                            </div>

                            <!-- Dropdown for Rooms and Trainings -->
                            <div
                                class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative"
                                x-data="{ dropdownOpen: false }" @mouseover="dropdownOpen = true"
                                @mouseout="dropdownOpen = false">
                                <x-nav-link
                                    :activeRoutes="['rooms.index', 'training-types.index', 'trainings.index']"
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
                        @endif

                        @if(Auth::user()->hasRole('admin'))
                            <!-- Dropdown for Services, Memberships, Insurances, and Sales -->
                            <div
                                class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative"
                                x-data="{ dropdownOpen: false }" @mouseover="dropdownOpen = true"
                                @mouseout="dropdownOpen = false">
                                <x-nav-link
                                    :activeRoutes="['memberships.index', 'insurances.index', 'sales.index']"
                                    class="flex items-center justify-center focus:outline-none">
                                    <i class="fa-solid fa-address-card text-xl transition-transform group-hover:-translate-y-1"></i>
                                </x-nav-link>
                                <div x-show="dropdownOpen"
                                     class="absolute mt-32 ml-32 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 z-50">
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

                            <!-- Settings Icon -->
                            <x-nav-link :href="route('settings.index')" :activeRoutes="['settings.index']"
                                        class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                                <i class="fa-solid fa-cog text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                                <span
                                    class="absolute bottom-1 transform translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all">Definições</span>
                            </x-nav-link>
                        @endif

                        @if(!Auth::user()->hasRole('admin'))
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
                        @endif

                        @if(Auth::user()->roles->count() > 1)
                            <x-nav-link :href="route('change-role')" :activeRoutes="['change-role']"
                                        class="group px-5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                                <i class="fa-solid fa-exchange-alt text-xl transition-transform group-hover:-translate-y-5 group-hover:scale-75"></i>
                                <span
                                    class="absolute bottom-1 text-center transform translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all">Alternar Perfil</span>
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <div class="flex items-center md:ms-6">
                <!-- Notification Bell Icon -->
                <button @click="notificationOpen = !notificationOpen" type="button"
                        class="relative flex items-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <i class="fa-solid fa-bell w-5 h-5 mb-1 text-lg"></i>
                    @if($unreadNotificationsCount > 0)
                        <span
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-red-100 transform -translate-x-2 translate-y-2 bg-red-600 rounded-full">{{ $unreadNotificationsCount }}</span>
                    @endif
                </button>

                <!-- Notification Modal -->
                <div x-show="notificationOpen" @click.away="notificationOpen = false"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div
                        class="bg-white dark:bg-gray-800 w-11/12 max-w-md mx-auto rounded-lg shadow-lg overflow-hidden">
                        <div
                            class="flex justify-between items-center px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Notificações</h2>
                            <button @click="notificationOpen = false"
                                    class="text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            @foreach($recentNotifications as $notification)
                                <div
                                    class="flex items-center justify-between p-2 border-b border-gray-200 dark:border-gray-700">
                                    <div class="mr-4">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $notification->message }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->locale('pt')->diffForHumans() }}</p>
                                        @if ($notification->read_at)
                                            <p class="text-xs text-gray-500 dark:text-gray-400"><i
                                                    class="fa-solid fa-check-double"></i> Lida</p>
                                        @endif
                                    </div>
                                    @if ($notification->url)
                                        <a href="{{ route('notifications.redirect', $notification->id) }}"
                                           class="text-blue-600 dark:text-lime-400 hover:underline text-sm">
                                            <i class="fa-solid {{ $notification->read_at ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                                            Ver
                                        </a>
                                    @elseif (!$notification->read_at)
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="text-blue-600 dark:text-lime-400 hover:underline text-sm">
                                                <i class="fa-solid fa-envelope"></i>
                                                Marcar como lido
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('notifications.index') }}"
                               class="text-blue-600 dark:text-lime-400 hover:underline text-sm">Ver todas as
                                notificações</a>
                        </div>
                    </div>
                </div>


                <!-- Theme Toggle Button -->
                <div class="flex items-center md:ms-6">
                    <button id="theme-toggle-nav" type="button"
                            class="theme-toggle-btn text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 mr-3 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon-nav" class="theme-toggle-dark-icon hidden w-5 h-5"
                             fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon-nav" class="theme-toggle-light-icon hidden w-5 h-5"
                             fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Settings Dropdown -->
                    <div class="hidden lg:flex md:items-center md:ms-6">
                        <div x-data="{ dropdownOpen: false }" @mouseover="dropdownOpen = true"
                             @mouseout="dropdownOpen = false" class="relative">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-blue-400 dark:hover:text-lime-400 focus:outline-none transition ease-in-out duration-150">
                                <div>
                                    <i class="fa-solid fa-user mr-2"></i>
                                    {{ Auth::user()->firstLastName() }}
                                </div>
                            </button>
                            <div x-show="dropdownOpen"
                                 class="absolute right-0 mt-0 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 z-50"
                                 @mouseover="dropdownOpen = true" @mouseout="dropdownOpen = false">
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

                    <!-- Hamburger Mobile -->
                    <div class="flex items-center lg:hidden">
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
        <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                       class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                    <i class="fa-solid fa-chart-line text-lg mr-2"></i>{{ __('Dashboard') }}
                </x-responsive-nav-link>

                @if(Auth::check())
                    @if(Auth::user()->hasRole('admin'))
                        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-users text-lg mr-2"></i>{{ __('Utilizadores') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('products.index')"
                                               :active="request()->routeIs('products.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-basket-shopping text-lg mr-2"></i>{{ __('Produtos') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('packs.index')" :active="request()->routeIs('packs.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-box text-lg mr-2"></i>{{ __('Packs') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-receipt text-lg mr-2"></i>{{ __('Vendas') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-door-open text-lg mr-2"></i>{{ __('Salas') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('training-types.index')"
                                               :active="request()->routeIs('training-types.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-person-walking text-lg mr-2"></i>{{ __('Tipos de Treino') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('trainings.index')"
                                               :active="request()->routeIs('trainings.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-dumbbell text-lg mr-2"></i>{{ __('Treinos') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('memberships.index')"
                                               :active="request()->routeIs('memberships.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-address-card text-lg mr-2"></i>{{ __('Matrículas') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('insurances.index')"
                                               :active="request()->routeIs('insurances.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-address-card text-lg mr-2"></i>{{ __('Seguros') }}
                        </x-responsive-nav-link>
                    @elseif(Auth::user()->hasRole('personal_trainer'))
                        <x-responsive-nav-link :href="route('products.index')"
                                               :active="request()->routeIs('products.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-basket-shopping text-lg mr-2"></i>{{ __('Produtos') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('packs.index')" :active="request()->routeIs('packs.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-box text-lg mr-2"></i>{{ __('Packs') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-receipt text-lg mr-2"></i>{{ __('Encomendas') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-door-open text-lg mr-2"></i>{{ __('Salas') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('training-types.index')"
                                               :active="request()->routeIs('training-types.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-person-walking text-lg mr-2"></i>{{ __('Tipos de Treino') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('trainings.index')"
                                               :active="request()->routeIs('trainings.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-dumbbell text-lg mr-2"></i>{{ __('Treinos') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('memberships.index')"
                                               :active="request()->routeIs('memberships.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-address-card text-lg mr-2"></i>{{ __('Matrículas') }}
                        </x-responsive-nav-link>
                    @elseif(Auth::user()->hasRole('client'))
                        <x-responsive-nav-link :href="route('products.index')"
                                               :active="request()->routeIs('products.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-basket-shopping text-lg mr-2"></i>{{ __('Produtos') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('packs.index')" :active="request()->routeIs('packs.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-box text-lg mr-2"></i>{{ __('Packs') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('trainings.index')"
                                               :active="request()->routeIs('trainings.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-dumbbell text-lg mr-2"></i>{{ __('Treinos') }}
                        </x-responsive-nav-link>
                    @elseif(Auth::user()->hasRole('employee'))
                        <x-responsive-nav-link :href="route('products.index')"
                                               :active="request()->routeIs('products.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-basket-shopping text-lg mr-2"></i>{{ __('Produtos') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-receipt text-lg mr-2"></i>{{ __('Encomendas') }}
                        </x-responsive-nav-link>
                    @endif

                    @if(!Auth::user()->hasRole('admin'))
                        @php
                            $cart = session()->get('cart', []);
                            $packCart = session()->get('packCart', []);
                            $cartCount = count($cart) + count($packCart);
                        @endphp

                        <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400 relative">
                            <i class="fa-solid fa-cart-shopping text-xl mr-2"></i>{{ __('Carrinho') }}
                            @if($cartCount > 0)
                                <span
                                    class="absolute top-2 left-6 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-red-100 transform translate-x-2 -translate-y-2 bg-red-600 rounded-full">{{ $cartCount }}</span>
                            @endif
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
                        <i class="fa-solid fa-user text-lg mr-2"></i>{{ __('Perfil') }}
                    </x-responsive-nav-link>

                    @if(Auth::user()->roles->count() > 1)
                        <x-responsive-nav-link :href="route('change-role')" :active="request()->routeIs('change-role')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-exchange-alt text-lg mr-2"></i>{{ __('Alternar Conta') }}
                        </x-responsive-nav-link>
                    @endif

                    @if(Auth::user()->hasRole('admin'))
                        <x-responsive-nav-link :href="route('settings.index')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400">
                            <i class="fa-solid fa-cog text-lg mr-2"></i>{{ __('Definições') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               class="text-gray-500 dark:text-gray-200 hover:text-blue-400 dark:hover:text-lime-400 focus:text-blue-400 dark:focus:text-lime-400"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            <i class="fa-solid fa-right-from-bracket text-lg mr-2"></i>{{ __('Sair') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
