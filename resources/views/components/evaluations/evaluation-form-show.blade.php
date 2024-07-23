<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="absolute top-4 left-4">
                <a href="{{ route('memberships.evaluations.list', ['membership' => $evaluation->membership_id]) }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="text-center">
                <h1 class="mb-8 mt-4 dark:text-lime-400 text-gray-800 font-semibold">Avaliação de {{ $evaluation->membership->user->full_name }} - {{ $evaluation->date }}</h1>
            </div>

            @foreach ([
                'weight' => ['Peso', 'kg'],
                'height' => ['Altura', 'cm'],
                'waist' => ['Cintura', 'cm'],
                'hip' => ['Quadril', 'cm'],
                'chest' => ['Peito', 'cm'],
                'arm' => ['Braço', 'cm'],
                'forearm' => ['Antebraço', 'cm'],
                'thigh' => ['Coxa', 'cm'],
                'calf' => ['Panturrilha', 'cm'],
                'abdominal_fat' => ['Gordura Abdominal', '%'],
                'visceral_fat' => ['Gordura Visceral', '%'],
                'muscle_mass' => ['Massa Muscular', 'kg'],
                'fat_mass' => ['Massa Gorda', 'kg'],
                'hydration' => ['Hidratação', '%'],
                'bone_mass' => ['Massa Óssea', 'kg'],
                'bmr' => ['Taxa Metabólica Basal', 'kcal'],
                'metabolic_age' => ['Idade Metabólica', 'anos'],
                'physical_evaluation' => ['Avaliação Física', ''],
                'fat_percentage' => ['Percentual de Gordura', '%'],
                'imc' => ['IMC', ''],
                'ideal_weight' => ['Peso Ideal', 'kg'],
                'ideal_fat_percentage' => ['Percentual de Gordura Ideal', '%'],
                'ideal_muscle_mass' => ['Massa Muscular Ideal', 'kg']
            ] as $field => $label)
                @if (!is_null($evaluation->$field))
                    <div class="mb-4">
                        <label for="{{ $field }}" class="block text-gray-800 dark:text-white">{{ $label[0] }} @if($label[1]) ({{ $label[1] }}) @endif</label>
                        <input class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" type="text" value="{{ $evaluation->$field }}" disabled>
                    </div>
                @endif
            @endforeach

            @if (!is_null($evaluation->observations))
                <div class="mb-4">
                    <label for="observations" class="block text-gray-800 dark:text-white">Observações</label>
                    <textarea class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 text-gray-800 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" disabled>{{ $evaluation->observations }}</textarea>
                </div>
            @endif

            <!-- Documentos -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Documentos</h2>
                <div class="bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md p-4">
                    @if($evaluation->documents->isEmpty())
                        <p class="text-gray-800 dark:text-gray-200">Nenhum documento disponível.</p>
                    @else
                        <ul id="uploaded-files-list">
                            @foreach($evaluation->documents as $document)
                                <li class="mb-2 flex justify-between items-center">
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 dark:text-lime-400 hover:underline">
                                        <i class="fa-solid fa-file mr-2"></i>{{ $document->name }}
                                    </a>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('personal_trainer'))
                                        <button type="button" class="text-red-600 dark:text-red-400 hover:underline ml-2" onclick="showConfirmationModal({{ $document->id }})">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $document->id }}" action="{{ route('evaluations.deleteDocument', [$evaluation->id, $document->id]) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- Área para adicionar documentos -->
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('personal_trainer'))
                        <div class="mt-4">
                            <form id="document-upload-form" action="{{ route('evaluations.addDocument', $evaluation->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-start space-y-2">
                                @csrf
                                <ul id="selected-files-list" class="list-disc pl-5 text-gray-800 dark:text-gray-200"></ul>
                                <label for="documents" class="cursor-pointer inline-flex items-center text-blue-600 dark:text-lime-400 hover:underline">
                                    <i class="fa-solid fa-plus mr-2"></i>Adicionar Documento(s)
                                </label>
                                <input type="file" name="documents[]" id="documents" accept=".pdf,.jpg,.png,.doc,.docx" multiple class="hidden" onchange="addSelectedFiles(event)">
                                <button type="submit" class="bg-blue-600 dark:bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 dark:hover:bg-lime-600">
                                    Upload
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end items-center mb-4 mt-10">
                @can('delete', $evaluation)
                    <form id="delete-form-{{$evaluation->id}}" action="{{ route('memberships.evaluations.destroy', ['membership' => $evaluation->membership_id, 'evaluation' => $evaluation->id]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="bg-red-600 text-white flex items-center px-4 py-2 rounded-md hover:bg-red-500" onclick="showEvaluationConfirmationModal({{ $evaluation->id }})">
                            <i class="fa-solid fa-trash-can w-4 h-4 mr-2"></i>
                            Eliminar
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação -->
<div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelAction()">Cancelar</button>
            <button type="button" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-500" onclick="confirmAction()">Confirmar</button>
        </div>
    </div>
</div>

<script>
    let selectedFiles = [];
    let deleteDocumentId = null;
    let evaluationDeleted = 0;

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

        document.getElementById('documents').value = '';
    }

    function removeSelectedFile(index) {
        selectedFiles.splice(index, 1);
        updateSelectedFilesList();
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

    function showConfirmationModal(documentId) {
        deleteDocumentId = documentId;
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    function showEvaluationConfirmationModal(id) {
        evaluationDeleted = id;
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    function cancelAction() {
        deleteDocumentId = null;
        evaluationDeleted = 0;
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    function confirmAction() {
        if (deleteDocumentId !== null) {
            fetch(document.getElementById(`delete-form-${deleteDocumentId}`).action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'DELETE'
                })
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            }).then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erro ao remover documento');
                }
            }).catch(error => {
                console.error('Erro:', error);
                alert('Erro ao remover documento');
            });
        } else if (evaluationDeleted !== 0) {
            document.getElementById(`delete-form-${evaluationDeleted}`).submit();
        }
        document.getElementById('confirmation-modal').classList.add('hidden');
    }

    document.getElementById('document-upload-form').addEventListener('submit', function(event) {
        const formData = new FormData();
        selectedFiles.forEach(file => formData.append('documents[]', file));

        event.preventDefault();

        fetch(this.action, {
            method: this.method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao carregar documentos');
            }
        }).catch(error => {
            console.error('Erro:', error);
            alert('Erro ao carregar documentos');
        });
    });
</script>
