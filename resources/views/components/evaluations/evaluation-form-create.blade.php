<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm bg-gray-300 relative">
            <div class="text-center mb-10">
                <h1 class="text-xl font-bold text-gray-800 dark:text-lime-400">Adicionar Avaliação</h1>
            </div>
            <form method="POST" action="{{ route('memberships.evaluations.store', ['membership' => $membership->id]) }}" enctype="multipart/form-data" id="evaluationForm">
                @csrf
                <input type="hidden" name="membership_id" value="{{ $membership->id }}">

                @foreach ([
                    'weight' => 'Peso',
                    'height' => 'Altura',
                    'waist' => 'Cintura',
                    'hip' => 'Quadril',
                    'chest' => 'Peito',
                    'arm' => 'Braço',
                    'forearm' => 'Antebraço',
                    'thigh' => 'Coxa',
                    'calf' => 'Panturrilha',
                    'abdominal_fat' => 'Gordura Abdominal',
                    'visceral_fat' => 'Gordura Visceral',
                    'muscle_mass' => 'Massa Muscular',
                    'fat_mass' => 'Massa Gorda',
                    'hydration' => 'Hidratação',
                    'bone_mass' => 'Massa Óssea',
                    'bmr' => 'Taxa Metabólica Basal',
                    'metabolic_age' => 'Idade Metabólica',
                    'physical_evaluation' => 'Avaliação Física',
                    'fat_percentage' => 'Percentual de Gordura',
                    'imc' => 'IMC',
                    'ideal_weight' => 'Peso Ideal',
                    'ideal_fat_percentage' => 'Percentual de Gordura Ideal',
                    'ideal_muscle_mass' => 'Massa Muscular Ideal'
                ] as $field => $label)
                    <div class="mb-4">
                        <label for="{{ $field }}" class="block text-sm font-medium dark:text-gray-200 text-gray-800">{{ $label }}</label>
                        <input type="number"
                               step="0.01"
                               id="{{ $field }}"
                               name="{{ $field }}"
                               class="mt-1 block w-full p-2 bg-gray-100 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:text-gray-200 placeholder-gray-500
                               @error($field) border-red-500 @enderror dark:bg-gray-600"
                               value="{{ old($field) }}"
                               aria-describedby="{{ $field }}Help">
                        @error($field)
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                @endforeach

                <div class="mb-4">
                    <label for="observations" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Observações</label>
                    <textarea id="observations"
                              name="observations"
                              class="mt-1 block w-full p-2 bg-gray-100 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:text-gray-200 placeholder-gray-500
                              @error('observations') border-red-500 @enderror dark:bg-gray-600"
                              aria-describedby="observationsHelp">{{ old('observations') }}</textarea>
                    @error('observations')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Data</label>
                    <input type="datetime-local"
                           id="date"
                           name="date"
                           class="mt-1 block w-full p-2 bg-gray-100 border-gray-300 border dark:border-gray-600 rounded-md shadow-sm text-gray-800 dark:text-gray-200 placeholder-gray-500
                           @error('date') border-red-500 @enderror dark:bg-gray-600"
                           value="{{ old('date') }}"
                           required
                           aria-describedby="dateHelp">
                    @error('date')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 mt-10">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('evaluationForm').addEventListener('submit', function(event) {
        let isFormValid = false;
        const inputs = this.querySelectorAll('input[type="number"], textarea');
        inputs.forEach(function(input) {
            if (input.value.trim() !== '') {
                isFormValid = true;
            }
        });

        if (!isFormValid) {
            event.preventDefault();
            alert('Por favor, preencha pelo menos um campo.');
        }
    });
</script>
