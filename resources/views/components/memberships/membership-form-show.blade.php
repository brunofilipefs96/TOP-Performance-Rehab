<div class="container mx-auto mt-5 pt-5 glass">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 mb-6 rounded">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-500 text-white p-4 mb-6 rounded">
            {{ session('error') }}
        </div>
    @endif

    @php
        $user = auth()->user();
        $birthDate = \Carbon\Carbon::parse($user->birth_date);
        $age = floor($birthDate->diffInYears(\Carbon\Carbon::now()));
    @endphp

        <!-- Client Alerts -->
    @if($user->hasRole('client'))
        @include('partials.client-alerts', ['membership' => $membership])
    @endif

    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-gray-300 dark:bg-gray-800 p-4 px-5 rounded-2xl shadow-sm relative">
            <div class="flex justify-center">
                <div class="w-full max-w-lg">
                    <div class="absolute top-4 left-4">
                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('memberships.index')  }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        @else
                            <a href="{{ url('/profile') }}" class="inline-block bg-gray-500 py-1 px-2 rounded-md shadow-sm hover:bg-gray-700 text-white">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        @endif
                    </div>
                    <div class="text-center">
                        <h1 class="mb-6 mt-8 text-2xl text-gray-900 dark:text-lime-400">Matrícula {{ $membership->id }}</h1>
                    </div>

                    <!-- User Details -->
                    @if($user->hasRole('personal_trainer'))
                        <div class="mb-4">
                            <label for="user_name" class="block text-gray-900 dark:text-gray-200">Nome do Utilizador</label>
                            <input type="text" value="{{ $membership->user->full_name }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="age" class="block text-gray-900 dark:text-gray-200">Idade</label>
                            <input type="text" value="{{ $age }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>
                    @else
                        <div class="mb-4">
                            <label for="user_name" class="block text-gray-900 dark:text-gray-200">Nome do Utilizador</label>
                            <input type="text" value="{{ $membership->user->full_name }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="nif" class="block text-gray-900 dark:text-gray-200">Número Identificação Fiscal</label>
                            <input type="text" value="{{ $membership->user->nif }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="cc_number" class="block text-gray-900 dark:text-gray-200">Número Contribuinte</label>
                            <input type="text" value="{{ $membership->user->cc_number }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>

                        <div class="mb-8">
                            <label for="birth_date" class="block text-gray-900 dark:text-gray-200">Data Nascimento</label>
                            <input type="text"
                                   value="{{ \Carbon\Carbon::parse($membership->user->birth_date)->format('d/m/Y') }}"
                                   disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>

                        <div>
                            <h1 class="mb-2 text-xl text-gray-900 dark:text-gray-200">Morada</h1>
                        </div>

                        <div class="mb-4">
                            <label for="address_name" class="block text-gray-900 dark:text-gray-200">Nome</label>
                            <input type="text" value="{{ $membership->address->name }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="address_street" class="block text-gray-900 dark:text-gray-200">Nome da Rua</label>
                            <input type="text" value="{{ $membership->address->street }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="address_city" class="block text-gray-900 dark:text-gray-200">Cidade</label>
                            <input type="text" value="{{ $membership->address->city }}" disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>

                        <div class="mb-5">
                            <label for="address_postal_code" class="block text-gray-900 dark:text-gray-200">Código-Postal</label>
                            <input type="text" id="address_postal_code" value="{{ $membership->address->postal_code }}"
                                   disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 dark:bg-gray-500 rounded-md shadow-sm">
                        </div>
                    @endif

                    <!-- Document Section -->
                    <div>
                        <h1 class="mb-2 text-2xl text-gray-900 dark:text-gray-200">Documentos</h1>
                    </div>
                    <div class="flex items-center mt-1 mb-6">
                        @foreach ($membership->user->entries as $entry)
                            @if ($entry->survey_id == 1)
                                <a href="{{ url('entries/'.$entry->id) }}">
                                    <button type="button"
                                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                                        Ficha de Anamnese
                                    </button>
                                </a>
                            @endif
                        @endforeach
                        <a href="{{ url('insurances/'.$membership->insurance->id) }}" class="pl-2">
                            <button type="button"
                                    class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-300 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-lime-800 transition ease-in-out duration-150">
                                Seguro
                            </button>
                        </a>
                    </div>

                    <!-- New section for questions and answers -->
                    <div class="mb-4">
                        <h2 class="mb-2 text-xl text-gray-900 dark:text-gray-200">Observações</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                @foreach ($membership->user->entries as $entry)
                                    @foreach ($entry->answers as $answer)
                                        @if($answer->question_id >= 14 && $answer->value != 'Nenhum' && $answer->question_id <= 18)
                                            @foreach(explode(', ', $answer->value) as $individualAnswer)
                                                <div class="flex items-center">
                                                    <span class="h-2 w-2 rounded-full inline-block mr-2 bg-gray-900 dark:bg-gray-200"></span>
                                                    <label class="block text-gray-900 dark:text-gray-200">{{ $individualAnswer }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                            <div>
                                @foreach ($membership->user->entries as $entry)
                                    @foreach ($entry->answers as $answer)
                                        @if($answer->question_id >= 19 && $answer->value != 'Nenhum' && $answer->question_id <= 22)
                                            @foreach(explode(', ', $answer->value) as $individualAnswer)
                                                <div class="flex items-center">
                                                    <span class="h-2 w-2 rounded-full inline-block mr-2 bg-gray-900 dark:bg-gray-200"></span>
                                                    <label class="block text-gray-900 dark:text-gray-200">{{ $individualAnswer }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Membership Status -->
                    <div class="flex items-center mb-2">
                        @if($membership->status->name == 'active')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Ativa</p>
                            <span class="h-3 w-3 bg-green-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'pending' || $membership->status->name == 'renew_pending')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Pendente</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'rejected')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Rejeitado</p>
                            <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'frozen')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Congelada</p>
                            <span class="h-3 w-3 bg-blue-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'pending_payment' || $membership->status->name == 'pending_renewPayment')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Pagamento em espera</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'inactive')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Inativa</p>
                            <span class="h-3 w-3 bg-red-500 rounded-full inline-block"></span>
                        @elseif($membership->status->name == 'awaiting_insurance')
                            <p class="dark:text-gray-100 text-gray-700 mr-2 align-middle text-lg">Estado: Aguarda renovação do seguro</p>
                            <span class="h-3 w-3 bg-yellow-500 rounded-full inline-block"></span>
                        @endif
                    </div>

                    <!-- Membership Dates -->
                    @if($membership->status->name == 'active')
                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-900 dark:text-gray-200">Data de Início</label>
                            <input type="text" id="start_date"
                                   value="{{ \Carbon\Carbon::parse($membership->start_date)->format('d/m/Y') }}"
                                   disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                        </div>
                        <div class="mb-4">
                            <label for="end_date" class="block text-gray-900 dark:text-gray-200">Data de Fim</label>
                            <input type="text" id="end_date"
                                   value="{{ \Carbon\Carbon::parse($membership->end_date)->format('d/m/Y') }}"
                                   disabled
                                   class="mt-1 block w-full p-2 border border-white dark:border-gray-500 text-gray-800 dark:text-gray-200 rounded-md shadow-sm dark:bg-gray-500">
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex justify-end mb-2">
                        @if($membership->status->name == 'active')
                            <a href="{{ route('memberships.evaluations.list', ['membership' => $membership->id]) }}"
                               class="inline-block border-tg dark:hover:bg-lime-300 bg-blue-500 dark:text-lime-800 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 text-white">
                                Avaliações
                            </a>
                        @endif
                        @can('update' , $membership)
                            @if($membership->status->name == 'pending' || $membership->status->name == 'frozen' || $membership->status->name == 'renew_pending')
                                <div class="flex justify-center">
                                    <form
                                        action="{{ route('memberships.update', ['membership' => $membership->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if($membership->status->name == 'pending')
                                            <input type="hidden" name="status_name" value="pending_payment">
                                            <button type="submit"
                                                    class="inline-block bg-green-500 mt-4 mr-1 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                                Aceitar
                                            </button>
                                        @elseif($membership->status->name == 'renew_pending')
                                            <input type="hidden" name="status_name" value="pending_renewPayment">
                                            <button type="submit"
                                                    class="inline-block bg-green-500 mt-4 mr-1 py-2 px-6 rounded-md shadow-sm hover:bg-green-700 text-white">
                                                Aceitar
                                            </button>
                                        @endif
                                    </form>
                                    <form
                                        action="{{ route('memberships.update', ['membership' => $membership->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_name" value="rejected">
                                        <button type="submit"
                                                class="inline-block bg-red-500 mt-4 py-2 px-5 rounded-md shadow-sm hover:bg-red-700 text-white">
                                            Rejeitar
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if($membership->status->name == 'active' || $membership->status->name == 'pending' || $membership->status->name == 'renew_pending')
                                <div class="flex items-center">
                                    <form
                                        action="{{ route('memberships.update', ['membership' => $membership->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_name" value="frozen">
                                        <button type="submit"
                                                class="inline-block bg-blue-500 ml-1 mt-4 py-2 px-6 rounded-md shadow-sm hover:bg-blue-700 text-white">
                                            Congelar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endcan
                    </div>

                    <!-- Documents Section -->
                    <div>
                        <h1 class="mb-2 text-xl text-gray-900 dark:text-gray-200">Documentos da Matrícula</h1>
                    </div>
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md p-4">
                        @if($membership->documents->isEmpty())
                            <p class="text-gray-800 dark:text-gray-200">Nenhum documento disponível.</p>
                        @else
                            <ul id="uploaded-files-list">
                                @foreach($membership->documents as $document)
                                    <li class="mb-2 flex justify-between items-center">
                                        <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 dark:text-lime-400 hover:underline">
                                            <i class="fa-solid fa-file mr-2"></i>{{ $document->name }}
                                        </a>
                                        @if(auth()->user()->hasRole('admin'))
                                            <button type="button" class="text-red-600 dark:text-red-400 hover:underline ml-2" onclick="showConfirmationModal({{ $document->id }})">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $document->id }}" action="{{ route('memberships.deleteDocument', [$membership->id, $document->id]) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Document Upload Area -->
                        @if(auth()->user()->hasRole('admin'))
                            <div class="mt-4">
                                <form id="document-upload-form" action="{{ route('memberships.addDocument', $membership->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-start space-y-2">
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
