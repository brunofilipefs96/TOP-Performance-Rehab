<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300">
            <div>
                <h1 class="mb-2 dark:text-lime-400 font-semibold text-gray-800">Utilizador {{$user->id}}</h1>
            </div>

            @if($user->image && file_exists(public_path('storage/' . $user->image)))
                <div class="mb-4 select-none ">
                    <label for="image" class="block">Imagem</label>
                    <img src="{{ asset('storage/' . $user->image) }}" alt="Imagem do Produto" class="mt-1 block w-full h-auto border border-gray-300 rounded-md shadow-sm">
                </div>
            @else
                <div class="mb-4">
                    <label for="image" class="block text-gray-800 dark:text-white">Imagem</label>
                    <div class="mt-1 block w-full h-40 bg-gray-100 dark:bg-gray-600 flex items-center justify-center text-white rounded-md shadow-sm">
                        <span class="text-xl dark:text-white text-gray-800">Sem imagem</span>
                    </div>
                </div>
            @endif
            <div class="mb-4">
                <label for="full_name" class="block dark:text-white text-gray-800">Nome Completo</label>
                <input type="text" value="{{$user->full_name}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="birth_date" class="block dark:text-white text-gray-800">Data de Nascimento</label>
                <input type="date" value="{{$user->birth_date}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="email" class="block dark:text-white text-gray-800">Email</label>
                <input type="email" value="{{$user->email}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block dark:text-white text-gray-800">Nº Telemóvel</label>
                <input type="text" value="{{$user->phone_number}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="gender" class="block dark:text-white text-gray-800">Género</label>
                <input type="text" value="{{ trim(
                    ($user->gender == 'male') ? 'Masculino' :
                    (($user->gender == 'female') ? 'Feminino' : $user->gender)
                    ) }}" disabled class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>


            <div class="mb-4">
                <label for="nif" class="block dark:text-white text-gray-800">NIF</label>
                <input type="text" value="{{$user->nif}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <div class="mb-10">
                <label for="cc_number" class="block dark:text-white text-gray-800">Nº CC</label>
                <input type="text" value="{{$user->cc_number}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>
            <h2 class="text-xl dark:text-white text-gray-800">Matrícula</h2>
            <div class="mt-1 block gap-4 p-2 dark:text-white mb-4">
                @if (!$user->membership)
                    <p class="dark:text-red-400 text-red-500">O Utilizador ainda não se matriculou.</p>
                @else
                    <p class="text-green-300">O Utilizador já possui uma matrícula.</p>
                    <a href="{{ route('memberships.show', ['membership' => $user->membership]) }}" class="bg-green-500 text-white py-2 px-6 rounded-md shadow-sm transition duration-300 ease-in-out hover:bg-green-700 hover:shadow-lg">Ver Detalhes da Matrícula</a>
                @endif
            </div>

            <div class="flex justify-end gap-2">
                @if ($user->membership)
                    <a href="{{ route('users.membership.show', ['membership' => $user->membership]) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-blue-400 dark:hover:bg-blue-300 dark:hover:text-blue-800">Detalhes da Matrícula</a>
                @endif
                <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 dark:bg-gray-400 dark:hover:bg-gray-300 dark:hover:text-gray-800">Voltar</button>
            </div>

        </div>
    </div>
</div>
