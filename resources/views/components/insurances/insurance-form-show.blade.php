<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm">
            <div class="flex justify-center relative">
                <div class="w-full max-w-lg">
                    <div class="absolute top-4 left-4">
                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('insurances.index')  }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        @else
                            <a href="{{ url('/profile') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        @endif
                    </div>
                    <div class="text-center">
                        <h1 class="mb-6 mt-8 text-2xl text-gray-900 dark:text-lime-400">Seguro {{ $insurance->id }}</h1>
                    </div>

                    <div class="mb-4">
                        <label for="user_name" class="block text-gray-900 dark:text-gray-200">Nome do Utilizador</label>
                        <input type="text" value="{{ $insurance->membership->user->full_name }}" disabled
                               class="mt-1 block w-full p-2 border dark:border-gray-500 border-white text-gray-800 dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div class="mb-4">
                        <label for="nif" class="block text-gray-900 dark:text-gray-200">Número Identificação Fiscal</label>
                        <input type="text" value="{{ $insurance->membership->user->nif }}" disabled
                               class="mt-1 block w-full p-2 border dark:border-gray-500 border-white text-gray-800 dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div>
                        <h1 class="mb-2 text-xl text-gray-900 dark:text-gray-200">Dados do Seguro</h1>
                    </div>

                    <div class="mb-4">
                        <label for="insurance_insurance_type" class="block text-gray-900 dark:text-gray-200">Tipo de Seguro</label>
                        <input type="text" id="insurance_insurance_type"
                               value="{{ $insurance->insurance_type }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-900 dark:text-gray-200">Data de Início</label>
                        <input type="text" id="start_date"
                               value="{{ \Carbon\Carbon::parse($insurance->start_date)->format('d/m/Y') }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-900 dark:text-gray-200">Data de Fim</label>
                        <input type="text" id="end_date"
                               value="{{ \Carbon\Carbon::parse($insurance->end_date)->format('d/m/Y') }}"
                               disabled
                               class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                    </div>

                    <div class="flex items-center mb-2">
                        @if($insurance->status)
                            @if($insurance->status->name == 'active')
                                <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Ativo</p>
                                <span class="h-3 w-3 bg-green-500 rounded-full inline-block"></span>
                            @elseif($insurance->status->name == 'pending' || $insurance->status->name == 'renew_pending')
                                <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Pendente</p>
                                <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                            @elseif($insurance->status->name == 'rejected')
                                <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Rejeitado</p>
                                <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                            @elseif($insurance->status->name == 'frozen')
                                <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Congelado</p>
                                <span class="h-3 w-3 bg-blue-500 rounded-full inline-block"></span>
                            @elseif($insurance->status->name == 'pending_payment' || $insurance->status->name == 'pending_renewPayment')
                                <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Pagamento em espera</p>
                                <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                            @elseif($insurance->status->name == 'inactive')
                                <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Inativa</p>
                                <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                            @elseif($insurance->status->name == 'awaiting_membership')
                                <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle">Estado: Aguarda renovação da matrícula</p>
                                <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                            @endif
                        @endif
                    </div>

                    <div class="flex justify-end mb-2">
                        @can('update', $insurance)
                            @if($insurance->status && ($insurance->status->name == 'pending' || $insurance->status->name == 'frozen' || $insurance->status->name == 'renew_pending'))
                                <div class="flex justify-center">
                                    @if($insurance->insurance_type == 'Pessoal')
                                        <form
                                            action="{{ route('insurances.update', ['insurance' => $insurance->id]) }}"
                                            method="POST" onsubmit="disableConfirmButton(this)">
                                            @csrf
                                            @method('PATCH')
                                            @if($insurance->status->name == 'pending')
                                                <input type="hidden" name="status_name" value="active">
                                                <button type="submit"
                                                        class="inline-block bg-green-500 mt-4 mr-1 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                                    Aceitar
                                                </button>
                                            @elseif($insurance->status->name == 'renew_pending')
                                                <input type="hidden" name="status_name" value="active">
                                                <button type="submit"
                                                        class="inline-block bg-green-500 mt-4 mr-1 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                                    Aceitar
                                                </button>
                                            @endif
                                        </form>
                                        <form
                                            action="{{ route('insurances.update', ['insurance' => $insurance->id]) }}"
                                            method="POST" onsubmit="disableConfirmButton(this)">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_name" value="rejected">
                                            <button type="submit"
                                                    class="inline-block bg-red-500 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-red-700 text-white">
                                                Rejeitar
                                            </button>
                                        </form>
                                    @elseif($insurance->insurance_type == 'Ginásio')
                                        <form
                                            action="{{ route('insurances.update', ['insurance' => $insurance->id]) }}"
                                            method="POST" onsubmit="disableConfirmButton(this)">
                                            @csrf
                                            @method('PATCH')
                                            @if($insurance->status->name == 'pending')
                                                <input type="hidden" name="status_name" value="pending_payment">
                                                <button type="submit"
                                                        class="inline-block bg-green-500 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                                    Aceitar
                                                </button>
                                            @elseif($insurance->status->name == 'renew_pending')
                                                <input type="hidden" name="status_name" value="pending_renewPayment">
                                                <button type="submit"
                                                        class="inline-block bg-green-500 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                                    Aceitar
                                                </button>
                                            @endif
                                        </form>
                                    @endif
                                </div>
                            @endif
                            @if($insurance->status && ($insurance->status->name == 'active' || $insurance->status->name == 'pending'))
                                <form
                                    action="{{ route('insurances.update', ['insurance' => $insurance->id]) }}"
                                    method="POST" onsubmit="disableConfirmButton(this)">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_name" value="frozen">
                                    <button type="submit"
                                            class="inline-block bg-blue-500 ml-1 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-blue-700 text-white">
                                        Congelar
                                    </button>
                                </form>
                            @endif
                        @endcan
                    </div>

                    <!-- Documentos -->
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Documentos</h2>
                        <div class="bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md p-4">
                            @if($insurance->documents->isEmpty())
                                <p class="text-gray-800 dark:text-gray-200">Nenhum documento disponível.</p>
                            @else
                                <ul id="uploaded-files-list">
                                    @foreach($insurance->documents as $document)
                                        <li class="mb-2 flex justify-between items-center">
                                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 dark:text-lime-400 hover:underline">
                                                <i class="fa-solid fa-file mr-2"></i>{{ $document->name }}
                                            </a>
                                            @if(auth()->user()->hasRole('admin'))
                                                <button type="button" class="text-red-600 dark:text-red-400 hover:underline ml-2" onclick="showConfirmationModal({{ $document->id }})">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $document->id }}" action="{{ route('insurances.deleteDocument', [$insurance->id, $document->id]) }}" method="POST" style="display:none;" onsubmit="disableConfirmButton(this)">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <!-- Área para adicionar documentos -->
                            @if(auth()->user()->hasRole('admin'))
                                <div class="mt-4">
                                    <form id="document-upload-form" action="{{ route('insurances.addDocument', $insurance->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-start space-y-2" onsubmit="disableConfirmButton(this)">
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

                </div>
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
            <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500" onclick="confirmAction()">Confirmar</button>
        </div>
    </div>
</div>

<script>
    let selectedFiles = [];
    let deleteDocumentId = null;

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

    function cancelAction() {
        deleteDocumentId = null;
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
                location.reload();
                return response.json();
            }).then(data => {
                if (data.success) {
                    location.reload();
                }
            }).catch(error => {
                location.reload();
                console.error('Erro:', error);
            });
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
            location.reload();
            return response.json();
        }).then(data => {
            if (data.success) {
                location.reload();
            }
        }).catch(error => {
            location.reload();
            console.error('Erro:', error);
        });
    });
</script>
