<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Avaliações</h1>

    @if(auth()->user()->hasRole('client'))
        <p class="mb-5 text-gray-800 dark:text-gray-200">Aqui é onde pode ver as suas Avaliações Físicas feitas no nosso
            Ginásio. Para Agendar Avaliações, contacte o Ginásio ou o seu Personal Trainer.</p>
    @elseif(auth()->user()->hasRole('admin') || auth()->user()->hasRole('personal_trainer'))
        <p class="mb-5 text-gray-800 dark:text-gray-200">Aqui pode Adicionar e Gerir as Avaliações do Cliente
            Selecionado.</p>
    @endif

    <hr class="mb-5 border-gray-400 dark:border-gray-300">

    @can('create', App\Models\Evaluation::class)
        <div class="mb-4">
            <h2 class="text-xl dark:text-white text-gray-800">Nome: {{ $membership->user->full_name }}</h2>
            <h3 class="text-lg dark:text-white text-gray-800">NIF: {{ $membership->user->nif }}</h3>
        </div>


        <div class="flex justify-between mb-4">
            <a href="{{ route('memberships.show', ['membership' => $membership->id]) }}"
               class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500">
                <i class="fa-solid fa-arrow-left mr-2"></i>Voltar para Matrícula
            </a>

            <a href="{{ route('memberships.evaluations.create', ['membership' => $membership->id]) }}"
               class="bg-blue-500 py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 text-white dark:bg-lime-400 dark:hover:bg-lime-300">
                <i class="fa-solid fa-plus mr-2"></i>Adicionar Avaliação
            </a>
        </div>
    @endcan

    <div class="table-container">
        <div class="overflow-x-auto">
            <table
                class="min-w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
                <thead>
                <tr>
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Data</th>
                    <th class="p-4 text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($evaluations as $evaluation)
                    <tr>
                        <td class="p-4">{{ $evaluation->id }}</td>
                        <td class="p-4">{{ $evaluation->date }}</td>
                        <td class="p-4 flex space-x-2 justify-center">
                            <a href="{{ route('memberships.evaluations.show', ['membership' => $membership->id, 'evaluation' => $evaluation->id]) }}"
                               class="bg-blue-500 dark:bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:hover:bg-lime-400">
                                <i class="fa-solid fa-eye mr-2"></i>Ver
                            </a>
                            @can('delete', $evaluation)
                                <button type="button"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-400"
                                        onclick="showDeleteModal({{ $evaluation->id }})">
                                    <i class="fa-solid fa-trash mr-2"></i>Eliminar
                                </button>
                                <form id="delete-form-{{ $evaluation->id }}"
                                      action="{{ route('memberships.evaluations.destroy', ['membership' => $membership->id, 'evaluation' => $evaluation->id]) }}"
                                      method="POST" style="display:none;" onsubmit="disableConfirmButton(this)">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $evaluations->links() }}
    </div>

    <!-- Modal de Confirmação -->
    <div id="confirmation-modal"
         class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
        <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
            <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende
                eliminar?</h2>
            <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
            <div class="flex justify-end gap-4">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400"
                        onclick="cancelDelete()">Cancelar
                </button>
                <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500"
                        onclick="confirmDelete();">Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let evaluationToDelete = null;

    function showDeleteModal(evaluationId) {
        evaluationToDelete = evaluationId;
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    function cancelDelete() {
        evaluationToDelete = null;
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function confirmDelete() {
        if (evaluationToDelete !== null) {
            document.getElementById(`delete-form-${evaluationToDelete}`).submit();
        }
    }
</script>
