<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div>
                <h1 class="mb-2">Utilizador {{$user->id}}</h1>
            </div>

            @php
                $imagePath = public_path($user->image);
            @endphp

            @if(file_exists($imagePath) && @getimagesize($imagePath))
                <div class="mb-4 select-none">
                    <label for="image" class="block">Imagem</label>
                    <img src="{{ asset($user->image) }}" alt="Imagem do Utilizador" class="mt-1 block w-full h-auto border border-gray-300 rounded-md shadow-sm">
                </div>
            @else
                <div class="mb-4 select-none">
                    <label for="image" class="block">Imagem</label>
                    <div class="mt-1 block w-full h-40 bg-gray-600 flex items-center justify-center text-white rounded-md shadow-sm">
                        <span class="text-xl">Sem imagem</span>
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <label for="full_name" class="block">Nome Completo</label>
                <input type="text" value="{{$user->full_name}}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="birth_date" class="block">Data de Nascimento</label>
                <input type="date" value="{{$user->birth_date}}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="email" class="block">Email</label>
                <input type="email" value="{{$user->email}}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block">Número de Telemóvel</label>
                <input type="text" value="{{$user->phone_number}}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="gender" class="block">Género</label>
                <input type="text" value="{{ trim(
                    ($user->gender == 'male') ? 'Masculino' :
                    (($user->gender == 'female') ? 'Feminino' : $user->gender)
                    ) }}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>


            <div class="mb-4">
                <label for="nif" class="block">NIF</label>
                <input type="text" value="{{$user->nif}}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="cc_number" class="block">Número do CC</label>
                <input type="text" value="{{$user->cc_number}}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mt-8 border-t border-gray-300 pt-8">
                @if (!$user->membership)
                    <h2 class="text-xl font-bold mb-4">Matrícula</h2>
                    <p class="mb-4">O Utilizador ainda não se matriculou.</p>
                    <a href="{{ route('users.memberships.create', $user) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700">Criar Matrícula</a>
                @else
                    <h2 class="text-xl font-bold mb-4">Matrícula</h2>
                    <p class="mb-5">O Utilizador já possui uma matrícula.</p>
                    <a href="{{ route('memberships.show', ['membership' => $user->membership]) }}" class="bg-green-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-green-700">Ver Detalhes da Matrícula</a>
                @endif
            </div>

        </div>
    </div>
</div>
