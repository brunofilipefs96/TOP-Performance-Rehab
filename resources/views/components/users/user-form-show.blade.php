<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="absolute top-4 left-4">
                <a href="{{ URL::previous() }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
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

            <div class="mb-4">
                <label for="cc_number" class="block dark:text-white text-gray-800">Cartão de Cidadão</label>
                <input type="text" value="{{$user->cc_number}}" disabled class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white">
            </div>

            <!-- Roles Section -->
            <h2 class="text-xl dark:text-white text-gray-800">Cargos</h2>
            <div class="mt-1 block gap-4 p-2 text-gray-700 dark:text-gray-200 mb-4">
                @foreach ($user->roles as $role)
                    <div class="flex items-center justify-between mb-2">
                        <span>{{ $role->name === 'client' ? 'Cliente' : ($role->name === 'personal_trainer' ? 'Personal Trainer' : ($role->name === 'employee' ? 'Funcionário' : 'Administrador')) }}</span>
                        @if($role->name !== 'client')
                            <form action="{{ route('user.roles.destroy', ['user' => $user->id, 'role' => $role->id]) }}" method="POST" class="remove-role-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="remove-role-button text-red-500 hover:text-red-700 ml-2">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            @if ($user->roles->isEmpty())
                <div class="mb-4">
                    <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition-all" onclick="openAddRoleModal()">
                        <i class="fa-solid fa-plus"></i> Adicionar Cargo
                    </button>
                </div>
            @elseif ($user->roles->contains('name', 'admin'))
                <div class="mb-4 text-red-500">
                    Para alterar o cargo deste utilizador necessita remover o cargo de Administrador.
                </div>
            @elseif ($user->roles->count() < 2)
                <div class="mb-4">
                    <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition-all" onclick="openAddRoleModal()">
                        <i class="fa-solid fa-plus"></i> Adicionar Cargo
                    </button>
                </div>
            @endif

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

<!-- Modal para Adicionar Cargo -->
<div id="addRoleModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Adicionar Cargo</h2>
        <form id="addRoleForm" action="{{ route('user.roles.store', $user->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="role" class="block dark:text-white text-gray-800">Selecione um cargo</label>
                <select name="role" id="role" class="mt-1 block w-full p-2 border-gray-300 border dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name === 'client' ? 'Cliente' : ($role->name === 'personal_trainer' ? 'Personal Trainer' : ($role->name === 'employee' ? 'Funcionário' : 'Administrador')) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="closeAddRoleModal()">Cancelar</button>
                <button type="submit" id="addRoleButton" class="bg-blue-500 hover:bg-blue-400 dark:bg-lime-500 text-white px-4 py-2 rounded-md dark:hover:bg-lime-400">Adicionar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Confirmação de Remoção de Cargo -->
<div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="closeConfirmationModal()">Cancelar</button>
            <button type="button" id="confirmRemoveButton" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Confirmar</button>
        </div>
    </div>
</div>

<script>
    function openAddRoleModal() {
        document.getElementById('addRoleModal').classList.remove('hidden');
    }

    function closeAddRoleModal() {
        document.getElementById('addRoleModal').classList.add('hidden');
    }

    function openConfirmationModal(form) {
        const confirmationModal = document.getElementById('confirmationModal');
        const confirmRemoveButton = document.getElementById('confirmRemoveButton');

        confirmRemoveButton.onclick = function() {
            form.submit();
        };

        confirmationModal.classList.remove('hidden');
    }

    function closeConfirmationModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }

    document.querySelectorAll('.remove-role-button').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.remove-role-form');
            openConfirmationModal(form);
        });
    });

    document.getElementById('addRoleForm').addEventListener('submit', function() {
        const addRoleButton = document.getElementById('addRoleButton');
        addRoleButton.disabled = true;
        addRoleButton.textContent = 'Processando...';
    });
</script>
