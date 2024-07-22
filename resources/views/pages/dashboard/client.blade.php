<x-app-layout>
    <div class="container mx-auto pt-5 mb-10">
        @if ($user->gender == 'male')
            <span class="text-3xl font-bold mb-2 dark:text-white text-gray-800">Bem vindo, <br> <span  class="text-blue-500 dark:text-lime-500" >{{ Auth::user()->firstLastName() }}</span>!</span>
        @elseif ($user->gender == 'female')
            <span class="text-3xl font-bold mb-2 dark:text-white text-gray-800">Bem vinda, <br> <span  class="text-blue-500 dark:text-lime-500" >{{ Auth::user()->firstLastName() }}</span>!</span>
        @else
            <span class="text-3xl font-bold mb-2 dark:text-white text-gray-800">Bem vind@, <br> <span  class="text-blue-500 dark:text-lime-500" >{{ Auth::user()->firstLastName() }}</span>!</span>
        @endif

        <hr class="mb-6 border-gray-400 dark:border-gray-300 mt-6">

        @if(!Auth::user()->membership)
            <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
                <p class="font-bold">Ainda não se matriculou no nosso ginásio</p>
                <p>Gostaria de se juntar a nós e começar a sua jornada fitness? </p>
                <p>Clique no botão abaixo para se matricular agora!</p>
                <a href="{{ route('setup') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Matricular-se</a>
            </div>
        @endif


            <!-- este if esta incorreto, quero um if onde vai ver se ja tem uma sale de matricula feita, para que desapareça. -->


            @if($user->addresses || $user->addresses->count() <= 0 && $user->membership && $user->membership->trainingTypes->count() <= 0 && $user->insurance)
            @if($user->membership && $user->membership->status->name == 'pending_payment' && $user->membership->insurance->status->name == 'pending_payment')
                <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
                    <p class="font-bold">A sua Matrícula e o seu seguro ja foram aprovados pelo administrador.</p>
                    <p>Para se juntar ao nosso ginásio, falta apenas fazer o processo de pagamento!</p>
                    <a href="{{ route('setup') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Realizar Pagamento</a>
                </div>
            @endif
        @endif

        @if(Auth::user()->membership && Auth::user()->membership->status_id == 2 && Auth::user()->membership->packs->isEmpty())
            <div class="bg-gray-300 border-l-4 dark:border-lime-500 border-blue-500 text-gray-700 dark:bg-gray-700 dark:text-gray-200 p-4 mb-6" role="alert">
                <p class="font-bold">Adquira Packs para Participar nas Aulas</p>
                <p>Para usufruir das nossas aulas e inscrever-se, adquira um dos nossos packs de aulas. Clique no botão abaixo para ver os packs disponíveis para si!</p>
                <a href="{{ route('packs.index') }}" class="mt-4 inline-block text-white dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400">Ver Packs</a>
            </div>
        @endif

        @if($products->count() > 0)
            <h1 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Temos produtos novos para si.</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <div
                        class="product-card dark:bg-gray-800 bg-gray-500 rounded-lg overflow-hidden shadow-md text-white select-none transform transition-transform duration-300 hover:scale-105 flex flex-col justify-between"
                        data-name="{{ $product->name }}">
                        <a href="{{ url('products/' . $product->id) }}" class="flex-grow">
                            <div class="flex justify-center">
                                @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                    <img src="{{ asset('storage/'. $product->image) }}" alt="{{ $product->name }}"
                                         class="w-full h-32 object-cover">
                                @else
                                    <div class="w-full h-32 dark:bg-gray-600 bg-gray-300 flex items-center justify-center">
                                        <span class="text-2xl">Sem imagem</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 dark:bg-gray-800 bg-gray-500 flex-grow">
                                <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                                <div class="dark:text-gray-300 text-gray-200 mb-2 flex items-center text-md">
                                    <i class="fa-solid fa-coins w-4 h-4 mr-2"></i>
                                    <span>{{ $product->price }} €</span>
                                </div>
                            </div>
                        </a>
                        <div class="flex justify-end items-center p-4 mt-auto space-x-2">
                            @if(!Auth::user()->hasRole('admin'))
                                <form id="add-cart-form-{{$product->id}}" action="{{ route('cart.addProduct') }}" method="POST"
                                      class="inline text-sm">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"
                                            class="dark:bg-lime-500 bg-blue-500 px-3 py-1 rounded-md dark:hover:bg-lime-400 hover:bg-blue-400 flex items-center">
                                        <i class="fa-solid fa-cart-plus w-4 h-4 inline-block fill-current text-white mr-2"></i>
                                        Adicionar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
                @else
                    <div class="flex justify-center">
                        <img  src="https://cdn.dribbble.com/users/1162077/screenshots/4672791/gym.gif" alt="">
                    </div>
                @endif
            </div>
    </div>
</x-app-layout>
