<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5 dark:text-white text-gray-800">Lista de Avaliações</h1>
    <hr class="mb-5 border-gray-400 dark:border-gray-300">

    <!-- Informações do cliente -->
    <div class="mb-4">
        <h2 class="text-xl dark:text-white text-gray-800">Nome: {{ $membership->user->full_name }}</h2>
        <h3 class="text-lg dark:text-white text-gray-800">NIF: {{ $membership->user->nif }}</h3>
    </div>

    <div class="flex justify-between mb-4">
        <a href="{{ route('memberships.show', ['membership' => $membership->id]) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500">
            Voltar para Matrícula
        </a>
        @can('create', App\Models\Evaluation::class)
            <a href="{{ route('memberships.evaluations.create', ['membership' => $membership->id]) }}" class="bg-blue-500 py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 text-white dark:bg-lime-400 dark:hover:bg-lime-300">
                Adicionar Avaliação
            </a>
        @endcan
    </div>

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-300 dark:bg-gray-800 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
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
                               class="bg-blue-500 dark:bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:hover:bg-lime-400">Ver</a>
                            <form action="{{ route('memberships.evaluations.destroy', ['membership' => $membership->id, 'evaluation' => $evaluation->id]) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-400">Eliminar</button>
                            </form>
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
</div>
