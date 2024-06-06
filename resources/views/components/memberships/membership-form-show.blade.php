<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center ">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div class="flex justify-center">
                <div class="w-full max-w-lg">

                    <div>
                        <h1 class="mb-2 text-2xl">Matrícula {{ $membership->id }}</h1>
                    </div>

                    <div class="mb-4">
                        <label for="user_name" class="block">Nome do Utilizador</label>
                        <input type="text" value="{{ $membership->user->full_name }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="nif" class="block">Número Identificação Fiscal</label>
                        <input type="text" value="{{ $membership->user->nif }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="cc_number" class="block">Número Contribuinte</label>
                        <input type="text" value="{{ $membership->user->cc_number }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-8">
                        <label for="birth_date" class="block">Data Nascimento</label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($membership->user->birth_date)->format('d/m/Y') }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div>
                        <h1 class="mb-2 text-xl">Morada</h1>
                    </div>

                    <div class="mb-4">
                        <label for="address_name" class="block">Nome</label>
                        <input type="text" value="{{ $membership->address->name }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_street" class="block">Nome da Rua</label>
                        <input type="text" value="{{ $membership->address->street }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_city" class="block">Cidade</label>
                        <input type="text" value="{{ $membership->address->city }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="address_postal_code" class="block">Código-Postal</label>
                        <input type="text" id="address_postal_code" value="{{ $membership->address->postal_code }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="monthly_plan">Plano Mensal</label>
                        <div class="mt-1 flex items-center">
                            <input type="radio" id="monthly_plan_yes" name="monthly_plan" value="yes"
                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ $membership->monthly_plan ? 'checked' : '' }} disabled>
                            <label for="monthly_plan_yes" class="ml-2 block">
                                Sim
                            </label>
                        </div>

                        <div class="mt-1 flex items-center">
                            <input type="radio" id="monthly_plan_no" name="monthly_plan" value="no"
                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ !$membership->monthly_plan ? 'checked' : '' }} disabled>
                            <label for="monthly_plan_no" class="ml-2 block">
                                Não
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="total_trainings_supervised" class="block">Total de Treinos com Personal Trainer</label>
                        <input type="text" value="{{ $membership->total_trainings_supervised }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="total_trainings_individual" class="block">Total de Treinos Individuais</label>
                        <input type="text" value="{{ $membership->total_trainings_individual }}" disabled
                               class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm">
                    </div>

                </div>
            </div>
            <div class="flex justify-center mb-4">
                <a href="{{ route('memberships.index') }}" class="inline-block bg-gray-500 mt-4 mb-5 py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

