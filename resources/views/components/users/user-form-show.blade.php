<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('users.index') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center">
                <h1 class="mb-8 mt-4 dark:text-lime-400 text-gray-800 font-semibold">{{ $user->firstLastName() }}</h1>
            </div>

            <div class="flex justify-center mt-4 mb-6">
                @if($user->image && file_exists(public_path('storage/' . $user->image)))
                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->firstLastName() }}" class="w-24 h-24 object-cover rounded-full border-2 border-gray-300">
                @else
                    <div class="w-24 h-24 bg-gray-300 dark:bg-gray-600 flex items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-600">
                        <i class="fa-solid fa-user text-4xl text-gray-800 dark:text-white"></i>
                    </div>
                @endif
            </div>

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
            <div class="mt-1 block gap-4 p-2 text-gray-700 dark:text-gray-200 mb-4">
                @if (!$user->membership)
                    <p class="dark:text-red-400 text-red-500">O Utilizador ainda não se matriculou.</p>
                @else
                    <p class="mb-6">O Utilizador já possui uma matrícula.</p>
                    <a href="{{ route('memberships.show', ['membership' => $user->membership]) }}" class="bg-green-500 text-white py-2 px-6 rounded-md shadow-sm transition duration-300 ease-in-out hover:bg-green-700 hover:shadow-lg">Ver Detalhes da Matrícula</a>
                @endif
            </div>

        </div>
    </div>
</div>
