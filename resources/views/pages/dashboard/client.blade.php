<x-app-layout>
        <div class="w-full h-full sm:pb-96">
                <div class="flex flex-no-wrap content-center">
                    <div style="min-height: 716px" class="w-64 absolute sm:relative bg-gray-800 shadow md:h-full flex-col justify-between hidden sm:flex">
                        <div class="px-8 ">
                            <div class="h-40 w-full flex items-center mt-8 mb-4">
                                <div class=" w-full flex flex-col items-center">
                                    <img src="{{ asset('storage/' . $user->image) }}" alt class="h-32 w-32 bg-gray-200 border rounded-full"
                                    />
                                    <span class="flex flex-col mt-2 content-center">
                                        <span class="text-lg">{{$user->full_name}}</span>
                                    </span>
                                </div>
                            </div>
                            <ul class="mt-6">
                                <li class="flex w-full justify-between text-gray-300 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                                    <a href="{{ url ('dashboard')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                        <i class="fa-solid fa-chart-line text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                                        <span class="text-md ml-2">Dashboard</span>
                                    </a>
                                </li>
                                <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                                    <a href="{{ url ('products')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                        <i class="fa-solid fa-basket-shopping text-xl transition-transform group-hover:-translate-y-1"></i>
                                        <span class="text-md ml-2">Produtos</span>
                                    </a>
                                </li>
                                <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                                    <a href="{{ url ('trainings')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                        <i class="fa-solid fa-dumbbell text-xl transition-transform group-hover:-translate-y-1"></i>
                                        <span class="text-md ml-2">Treinos</span>
                                    </a>
                                </li>
                                <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                                    <a href="javascript:void(0)" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                        <i class="fa-regular fa-calendar text-2xl transition-transform group-hover:-translate-y-1"></i>
                                        <span class="text-md ml-2">agenda</span>
                                    </a>
                                </li>
                                <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-4 dark:hover:text-lime-400 hover:text-blue-600">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="javascript:void(0)"  class="flex items-center focus:outline-none focus:ring-2 focus:ring-white" onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                            <i class="fa-solid fa-right-from-bracket text-2xl transition-transform group-hover:-translate-y-1"></i>
                                            <span class="text-sm ml-2">Sair</span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="w-64 z-40 absolute bg-gray-800 shadow md:h-full flex-col justify-between sm:hidden transition duration-150 ease-in-out" id="mobile-nav">
                        <button aria-label="toggle sidebar" id="openSideBar" class="h-10 w-10 absolute right-0 -mt-1 -mr-20 flex items-center shadow rounded-tr rounded-br justify-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 rounded focus:ring-gray-800" onclick="sidebarHandler(true)">
                            <i class="fa-solid fa-bars text-xl text-gray-400 bg-gray-900"></i>
                        </button>
                        <button aria-label="Close sidebar" id="closeSideBar" class="hidden h-10 w-10 bg-gray-800 absolute right-0 mt-3 mr-5 flex items-center justify-center cursor-pointer text-white" onclick="sidebarHandler(false)">
                            <svg  xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                        <div class="px-8">
                            <div class="h-40 w-full flex items-center">
                                <div class="flex flex-col items-center">
                                    <img src="{{ asset('storage/' . $user->image) }}" alt class="h-32 w-32 bg-gray-200 border rounded-full"
                                    />
                                    <span class="flex flex-col ml-2">
                                        <span class="truncate w-20 font-bold tracking-wide leading-none">{{$user->full_name}}</span>
                                    </span>
                                </div>
                            </div>
                            <ul class="mt-12">
                                <li class="flex w-full justify-between text-gray-300 cursor-pointer items-center mb-6 dark:hover:text-lime-400 hover:text-blue-600">
                                    <a href="{{ url ('dashboard')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                        <i class="fa-solid fa-chart-line text-xl transition-transform group-hover:-translate-y-2 group-hover:scale-75"></i>
                                        <span class="text-md ml-2">Dashboard</span>
                                    </a>
                                </li>
                                <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-6 dark:hover:text-lime-400 hover:text-blue-600">
                                    <a href="{{ url ('products')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                        <i class="fa-solid fa-basket-shopping text-xl transition-transform group-hover:-translate-y-1"></i>
                                        <span class="text-md ml-2">Produtos</span>
                                    </a>
                                </li>
                                <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-6 dark:hover:text-lime-400 hover:text-blue-600">
                                    <a href="{{ url ('trainings')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white" >
                                        <i class="fa-solid fa-dumbbell text-xl transition-transform group-hover:-translate-y-1"></i>
                                        <span class="text-md ml-2">Treinos</span>
                                    </a>
                                </li>
                                <li class="flex w-full justify-between text-gray-400 cursor-pointer items-center mb-6 dark:hover:text-lime-400 hover:text-blue-600">
                                    <a href="javascript:void(0)" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                        <i class="fa-regular fa-calendar text-2xl transition-transform group-hover:-translate-y-1"></i>
                                        <span class="text-md ml-2">agenda</span>
                                    </a>
                                </li>
                                <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="javascript:void(0)"  class="flex items-center focus:outline-none focus:ring-2 focus:ring-white" onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                                <i class="fa-solid fa-right-from-bracket text-2xl transition-transform group-hover:-translate-y-1"></i>
                                                <span class="text-sm ml-2">Sair</span>
                                            </a>
                                        </form>
                                </li>
                            </ul>
                            <div class="flex justify-center mt-48 mb-4 w-full">
                                <div class="relative">
                                    <div class="text-gray-300 absolute ml-4 inset-0 m-auto w-4 h-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"></path>
                                            <circle cx="10" cy="10" r="7"></circle>
                                            <line x1="21" y1="21" x2="15" y2="15"></line>
                                        </svg>
                                    </div>
                                    <input class="bg-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-100  rounded w-full text-sm text-gray-300 placeholder-gray-400 pl-10 py-2" type="text" placeholder="Search" />
                                </div>
                            </div>
                        </div>
                        <div class="px-8 border-t border-gray-700">
                            <ul class="w-full flex items-center justify-between bg-gray-800">
                                <li class="cursor-pointer text-white pt-5 pb-3">
                                    <button aria-label="show notifications" class="focus:outline-none focus:ring-2 rounded focus:ring-gray-300">
                                        <svg  xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"></path>
                                            <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                                            <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                                        </svg>
                                    </button>
                                </li>
                                <li class="cursor-pointer text-white pt-5 pb-3">
                                    <button aria-label="open chats" class="focus:outline-none focus:ring-2 rounded focus:ring-gray-300">
                                        <svg  xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-messages" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"></path>
                                            <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10"></path>
                                            <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2"></path>
                                        </svg>
                                    </button>
                                </li>
                                <li class="cursor-pointer text-white pt-5 pb-3">
                                    <button aria-label="open settings" class="focus:outline-none focus:ring-2 rounded focus:ring-gray-300">
                                        <svg  xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"></path>
                                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </button>
                                </li>
                                <li class="cursor-pointer text-white pt-5 pb-3">
                                    <button aria-label="open logs" class="focus:outline-none focus:ring-2 rounded focus:ring-gray-300">
                                        <svg  xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-archive" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"></path>
                                            <rect x="3" y="4" width="18" height="4" rx="2"></rect>
                                            <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10"></path>
                                            <line x1="10" y1="12" x2="14" y2="12"></line>
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Sidebar ends -->
                    <!-- Remove class [ h-64 ] when adding a card block -->
                    <div class="container h-screen mx-auto py-10 h-64 md:w-4/5 w-11/12 px-6">
                        <!-- Remove class [ border-dashed border-2 border-gray-300 ] to remove dotted border -->
                        <div class="w-full h-full0">
                            <h1 class="text-2xl font-bold mb-5">Produtos em destaque</h1>
                            <div class="h-full grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($products as $product)
                                    <div class="product-card dark:bg-gray-800 rounded-lg overflow-hidden shadow-md text-white select-none" data-name="{{ $product->name }}">
                                        <div class="flex justify-center">
                                            @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                                <img src="{{ asset('storage/'. $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                                            @else
                                                <div class="w-full h-32 dark:bg-gray-600 bg-gray-300 flex items-center justify-center ">
                                                    <span class="text-2xl">Sem imagem</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-2 dark:bg-gray-800 bg-gray-500">
                                            <h3 class="text-l font-semibold mb-2">{{ $product->name }}</h3>
                                            <p class="text-gray-400 font-semibold mb-2">Preço: {{ $product->price }}€</p>
                                            <div class="flex justify-end items-center mt-4 gap-2">
                                                <a href="{{ url('products/' . $product->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-400 dark:bg-gray-400 dark:hover:bg-gray-300">Mostrar</a>
                                                @can('update', $product)
                                                    <a href="{{ url('products/' . $product->id . '/edit') }}" class="bg-blue-600 text-white px-2 py-1 rounded-md hover:bg-blue-500 dark:bg-gray-500 dark:hover:bg-gray-400">Editar</a>
                                                @endcan
                                                @can('delete', $product)
                                                    <form id="delete-form-{{$product->id}}" action="{{ url('products/' . $product->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-500" id="delete-button" onclick="confirmDelete({{ $product->id }})">Eliminar</button>
                                                    </form>

                                                    <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                                        <div class="bg-gray-300 p-6 rounded-md shadow-md w-96 dark:bg-gray-900">
                                                            <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
                                                            <p class="mb-4 dark:text-red-300 text-red-500">Não poderá reverter isso!</p>
                                                            <div class="flex justify-end gap-4">
                                                                <button id="cancel-button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400">Cancelar</button>
                                                                <button id="confirm-button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Eliminar</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var sideBar = document.getElementById("mobile-nav");
                    var openSidebar = document.getElementById("openSideBar");
                    var closeSidebar = document.getElementById("closeSideBar");
                    sideBar.style.transform = "translateX(-300px)";

                    function sidebarHandler(flag) {
                        if (flag) {
                            sideBar.style.transform = "translateX(-20px)";
                            openSidebar.classList.add("hidden");
                            closeSidebar.classList.remove("hidden");
                        } else {
                            sideBar.style.transform = "translateX(-300px)";
                            closeSidebar.classList.add("hidden");
                            openSidebar.classList.remove("hidden");
                        }
                    }
                </script>
        </div>

{{--    <div class="container mx-auto mt-5">--}}
{{--        <h1 class="text-2xl font-bold mb-5 text-gray-800 dark:text-gray-200">Bem-vindo {{ Auth::user()->firstLastName() }}</h1>--}}

{{--        <div class="py-10">--}}
{{--            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 text-gray-900 dark:text-gray-100">--}}
{{--                    <div class="mt-4 mb-10">--}}
{{--                        <h3 class="text-2xl font-medium mb-3 text-center">Calendário Semanal</h3>--}}
{{--                        <div class="flex justify-center items-center">--}}
{{--                            <form method="POST" action="{{ route('dashboard.changeWeek') }}" class="mr-2">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="direction" value="previous">--}}
{{--                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-900 font-bold py-2 px-4 rounded">--}}
{{--                                    <<--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                            <!-- Display current week range -->--}}
{{--                            <div class="mx-4 text-lg font-semibold">--}}
{{--                                {{ \Carbon\Carbon::parse($startOfWeek)->format('d M') }} - {{ \Carbon\Carbon::parse($startOfWeek)->addDays(6)->format('d M') }}--}}
{{--                            </div>--}}
{{--                            <form method="POST" action="{{ route('dashboard.changeWeek') }}" class="ml-2">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="direction" value="next">--}}
{{--                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-900 font-bold py-2 px-4 rounded">--}}
{{--                                    >>--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                        <div class="flex justify-center mb-6 items-center">--}}
{{--                            <h3 class="text-lg font-medium mb-3 text-center">{{ date('Y') }}</h3>--}}
{{--                        </div>--}}
{{--                        <div class="flex justify-center">--}}
{{--                            <div class="max-w-4xl w-full">--}}
{{--                                <!-- Wrapper for scrolling -->--}}
{{--                                <div class="overflow-x-auto">--}}
{{--                                    <div class="min-w-max lg:min-w-0">--}}
{{--                                        <div class="grid grid-cols-8 text-xs font-medium text-gray-700 dark:text-gray-300 rounded-t-lg">--}}
{{--                                            <div class="bg-gray-300 dark:bg-gray-700 p-2 text-center rounded-tl-lg border-r">Hora</div>--}}
{{--                                            @foreach (['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'] as $index => $day)--}}
{{--                                                <div class="bg-blue-500 dark:bg-lime-500 text-white p-2 text-center border-l {{ $index == 6 ? 'rounded-tr-lg' : '' }}">--}}
{{--                                                    {{ $day }} {{ \Carbon\Carbon::parse($startOfWeek)->addDays($index)->format('d/m') }}--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                        @for ($hour = 6; $hour <= 23; $hour++)--}}
{{--                                            <div class="grid grid-cols-8 border-b">--}}
{{--                                                <div class="bg-gray-200 dark:bg-gray-600 text-center p-2 border-r">{{ $hour }}:00</div>--}}
{{--                                                @for ($day = 0; $day < 7; $day++)--}}
{{--                                                    <div class="p-2 bg-gray-100 dark:bg-gray-500 border-l">--}}
{{--                                                        @foreach ($trainings as $training)--}}
{{--                                                            @php--}}
{{--                                                                $startDateTime = \Carbon\Carbon::parse($training->start_date);--}}
{{--                                                                $endDateTime = \Carbon\Carbon::parse($training->end_date);--}}
{{--                                                            @endphp--}}
{{--                                                            @if ($startDateTime->hour == $hour && $startDateTime->dayOfWeek == $day)--}}
{{--                                                                <a href="{{ route('trainings.show', $training->id) }}" class="bg-blue-200 dark:bg-lime-500 rounded-lg p-1 text-center block border border-blue-300 dark:border-lime-300 hover:bg-blue-300 dark:hover:bg-lime-300">--}}
{{--                                                                    <span class="block text-xs">{{ $training->trainingType->name }}</span>--}}
{{--                                                                    <span class="block text-xs">{{ $startDateTime->format('H:i') }} - {{ $endDateTime->format('H:i') }}</span>--}}
{{--                                                                </a>--}}
{{--                                                            @endif--}}
{{--                                                        @endforeach--}}
{{--                                                    </div>--}}
{{--                                                @endfor--}}
{{--                                            </div>--}}
{{--                                        @endfor--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</x-app-layout>
