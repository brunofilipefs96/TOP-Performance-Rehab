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
                    'weight' => 'Peso (Kg)',
                    'height' => 'Altura (Cm)',
                    'waist' => 'Cintura (Cm)',
                    'hip' => 'Quadril (Cm)',
                    'chest' => 'Peito (Cm)',
                    'arm' => 'Braço (Cm)',
                    'forearm' => 'Antebraço (Cm)',
                    'thigh' => 'Coxa (Cm)',
                    'calf' => 'Panturrilha (Cm)',
                    'abdominal_fat' => 'Gordura Abdominal (%)',
                    'visceral_fat' => 'Gordura Visceral (%)',
                    'muscle_mass' => 'Massa Muscular (%)',
                    'fat_mass' => 'Massa Gorda (%)',
                    'hydration' => 'Hidratação (%)',
                    'bone_mass' => 'Massa Óssea (%)',
                    'bmr' => 'Taxa Metabólica Basal (Kcal)',
                    'metabolic_age' => 'Idade Metabólica (Anos)',
                    'physical_evaluation' => 'Avaliação Física',
                    'fat_percentage' => 'Percentual de Gordura (%)',
                    'imc' => 'IMC',
                    'ideal_weight' => 'Peso Ideal (Kg)',
                    'ideal_fat_percentage' => 'Percentual de Gordura Ideal (%)',
                    'ideal_muscle_mass' => 'Massa Muscular Ideal (%)'
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

                <div class="mb-4">
                    <label for="documents" class="block text-sm font-medium dark:text-gray-200 text-gray-800">Documentos</label>
                    <input type="file"
                           id="documents"
                           name="documents[]"
                           class="mt-1 block w-full text-gray-800 dark:text-gray-200 dark:bg-gray-600"
                           multiple
                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                           onchange="addSelectedFiles(event)">
                    @error('documents')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <ul id="selected-files-list" class="list-disc pl-5 mt-2 text-gray-800 dark:text-gray-200"></ul>
                </div>

                <div id="error-message" class="hidden text-red-500 text-sm mb-4">
                    <strong>Por favor, preencha pelo menos um campo ou adicione um arquivo.</strong>
                </div>

                <div class="flex justify-end gap-2 mt-10">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:text-gray-900 dark:hover:bg-lime-300 text-sm" id="submit-button" disabled>Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let selectedFiles = [];

    function addSelectedFiles(event) {
        const files = event.target.files;
        const list = document.getElementById('selected-files-list');

        for (let i = 0; i < files.length; i++) {
            selectedFiles.push(files[i]);
            const li = document.createElement('li');
            li.className = 'mb-2 flex justify-between items-center';
            li.innerHTML = `
                <span><i class="fa-solid fa-file mr-2"></i>${files[i].name}</span>
                <button type="button" class="text-red-600 dark:text-red-400 hover:underline ml-2" onclick="removeSelectedFile(${selectedFiles.length - 1})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            `;
            list.appendChild(li);
        }

        document.getElementById('documents').value = ''; // Clear the input
        checkFormValidity();
    }

    function removeSelectedFile(index) {
        selectedFiles.splice(index, 1);
        updateSelectedFilesList();
        checkFormValidity();
    }

    function updateSelectedFilesList() {
        const list = document.getElementById('selected-files-list');
        list.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const li = document.createElement('li');
            li.className = 'mb-2 flex justify-between items-center';
            li.innerHTML = `
                <span><i class="fa-solid fa-file mr-2"></i>${file.name}</span>
                <button type="button" class="text-red-600 dark:text-red-400 hover:underline ml-2" onclick="removeSelectedFile(${index})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            `;
            list.appendChild(li);
        });
    }

    function checkFormValidity() {
        const inputs = document.querySelectorAll('input[type="number"], textarea');
        let isFormValid = false;

        inputs.forEach(function(input) {
            if (input.value.trim() !== '') {
                isFormValid = true;
            }
        });

        if (selectedFiles.length > 0) {
            isFormValid = true;
        }

        document.getElementById('submit-button').disabled = !isFormValid;
        document.getElementById('error-message').classList.toggle('hidden', isFormValid);
        return isFormValid;
    }

    document.querySelectorAll('input[type="number"], textarea').forEach(input => {
        input.addEventListener('input', checkFormValidity);
    });

    document.getElementById('evaluationForm').addEventListener('submit', function(event) {
        const formData = new FormData(this);
        selectedFiles.forEach(file => formData.append('documents[]', file));
        // Substituindo a submissão padrão pelo fetch para garantir que os arquivos sejam enviados
        event.preventDefault();

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        }).then(response => response.json()).then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert('Erro ao criar avaliação.');
            }
        }).catch(error => {
            console.error('Erro:', error);
            alert('Erro ao criar avaliação.');
        });
    });
</script>
