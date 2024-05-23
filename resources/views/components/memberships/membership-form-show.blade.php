<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div>
                <h1 class="mb-2">Matrícula {{ $membership->id }}</h1>
            </div>

            <div class="mb-4">
                <label for="user_name" class="block">Nome do Utilizador</label>
                <input type="text" value="{{ $membership->user->full_name }}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="monthly_plan" class="block">Plano Mensal</label>
                <input type="text" value="{{ $membership->monthly_plan ? 'Sim' : 'Não' }}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="total_trainings" class="block">Total de Treinos</label>
                <input type="text" value="{{ $membership->total_trainings }}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="created_at" class="block">Data de Criação</label>
                <input type="text" value="{{ $membership->created_at->format('d/m/Y H:i:s') }}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="updated_at" class="block">Data da última Atualização</label>
                <input type="text" value="{{ $membership->updated_at->format('d/m/Y H:i:s') }}" disabled class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
            </div>
        </div>
    </div>
</div>
