<div class="container mx-auto mt-5 p-5 glass rounded-lg shadow-md bg-white dark:bg-gray-800">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Encomenda nº {{ $sale->id }}</h1>
        <hr class="border-gray-400 dark:border-gray-600">
    </div>

    <!-- Dados do Cliente -->
    <div class="mb-6">
        @if(auth()->id() == $sale->user_id)
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Os seus dados</h2>
        @else
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Dados do Cliente</h2>
        @endif
        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md">
            <p><strong class="text-gray-800 dark:text-gray-200">Nome:</strong> <span
                    class="text-gray-900 dark:text-gray-300">{{ $sale->user->full_name ?? 'N/A' }}</span></p>
            <p><strong class="text-gray-800 dark:text-gray-200">Rua:</strong> <span
                    class="text-gray-900 dark:text-gray-300">{{ $sale->address->street ?? 'N/A' }}, {{ $sale->address->city ?? 'N/A' }}</span>
            </p>
            <p><strong class="text-gray-800 dark:text-gray-200">Código Postal:</strong> <span
                    class="text-gray-900 dark:text-gray-300">{{ $sale->address->postal_code ?? 'N/A' }}</span></p>
        </div>
    </div>

    <!-- Dados da Encomenda -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Dados da Encomenda</h2>
        <div class="overflow-x-auto p-4 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md">
            @if($sale->products->count() == 0 && $sale->packs->count() == 0)
                <div class="text-center p-4">
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pagamento de Taxa de Inscrição/Seguro</p>
                    <p class="text-gray-800 dark:text-gray-200">Total: {{ number_format($sale->total, 2) }} €</p>
                </div>
            @else
                <table
                    class="min-w-full bg-gray-200 dark:bg-gray-700 rounded-2xl shadow-md text-gray-900 dark:text-gray-200">
                    <thead>
                    <tr>
                        <th class="p-4 text-left">Artigo</th>
                        <th class="p-4 text-center">Quantidade</th>
                        @if(auth()->user()->hasRole('admin'))
                            <th class="p-4 text-center">Quantidade em Falta</th>
                        @endif
                        <th class="p-4 text-center">Preço</th>
                        <th class="p-4 text-center">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sale->products as $product)
                        <tr class="{{ $product->pivot->quantity_shortage > 0 ? 'bg-red-100 dark:bg-red-900' : '' }}">
                            <td class="p-4 text-left">
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="dark:hover:text-lime-400 hover:text-blue-500">
                                    <i class="fa-solid fa-basket-shopping mr-2"></i>
                                    @if($product->pivot->quantity_shortage > 0)
                                        <i class="fa-solid fa-triangle-exclamation text-yellow-500 dark:text-yellow-300 mr-1"></i>
                                    @endif
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td class="p-4 text-center">{{ $product->pivot->quantity }}</td>
                            @if(auth()->user()->hasRole('admin'))
                                <td class="p-4 text-center {{ $product->pivot->quantity_shortage > 0 ? 'text-red-500' : '' }}">
                                    {{ $product->pivot->quantity_shortage }}
                                </td>
                            @endif
                            <td class="p-4 text-center">{{ number_format($product->pivot->price, 2) }} €</td>
                            <td class="p-4 text-center">{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}
                                €
                            </td>
                        </tr>
                    @endforeach
                    @foreach($sale->packs as $pack)
                        <tr>
                            <td class="p-4 text-left">
                                <a href="{{ route('packs.show', $pack->id) }}"
                                   class="dark:hover:text-lime-400 hover:text-blue-500">
                                    <i class="fa-solid fa-box mr-2"></i>{{ $pack->name }}
                                </a>
                            </td>
                            <td class="p-4 text-center">{{ $pack->pivot->quantity }}</td>
                            @if(auth()->user()->hasRole('admin'))
                                <td class="p-4 text-center">N/A</td>
                            @endif
                            <td class="p-4 text-center">{{ number_format($pack->pivot->price, 2) }} €</td>
                            <td class="p-4 text-center">{{ number_format($pack->pivot->price * $pack->pivot->quantity, 2) }}
                                €
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="mt-4 pt-4 border-t-2 border-gray-400 dark:border-gray-600">
            <div class="flex justify-end items-center text-gray-800 dark:text-gray-100">
                <span class="text-lg font-bold mr-2">Total:</span>
                <span class="text-lg font-bold">{{ number_format($sale->total, 2) }} €</span>
            </div>
        </div>
    </div>

    <!-- Estado da Encomenda -->
    <div>
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Estado da Encomenda</h2>
        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md">
            <p><strong class="text-gray-800 dark:text-gray-200">Estado:</strong> <span
                    class="text-gray-900 dark:text-gray-300">{{ $sale->translated_status }}</span></p>
        </div>
        @if(Auth::user()->hasRole('client'))
            @if($sale->status_id == 6 && $sale->products->count() > 0)
                <div class="mt-4 p-4 bg-yellow-500 dark:bg-yellow-700 text-white rounded-lg shadow-md">
                    <p><strong>Aguarde:</strong> A sua encomenda foi paga. Você será notificado quando estiver pronta
                        para recolha.</p>
                </div>
            @elseif($sale->status_id == 16 && $sale->products->count() > 0)
                <div class="mt-4 p-4 bg-green-500 dark:bg-green-700 text-white rounded-lg shadow-md">
                    <p><strong>Pronto para Recolha:</strong> A sua encomenda está pronta para ser recolhida. Por favor,
                        dirija-se ao ginásio para levantá-la.</p>
                </div>
            @endif
        @endif
        @if(auth()->user()->hasRole('admin') && $sale->status_id == 6 && $sale->products->count() > 0)
            <div class="mt-4">
                <form action="{{ route('sales.updateStatus', $sale->id) }}" method="POST" onsubmit="disableConfirmButton(this)">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status_id" value="16">
                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700">
                        Marcar como Pronta para Recolha
                    </button>
                </form>
            </div>
        @elseif(auth()->user()->hasRole('admin') && $sale->status_id == 16 && $sale->products->count() > 0)
            <div class="mt-4">
                <form action="{{ route('sales.updateStatus', $sale->id) }}" method="POST" onsubmit="disableConfirmButton(this)">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status_id" value="8">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Marcar
                        como Entregue
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Documentos -->
    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Documentos</h2>
        <div class="bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md p-4">
            @if($sale->documents->isEmpty())
                <p class="text-gray-800 dark:text-gray-200">Nenhum documento disponível.</p>
            @else
                <ul id="uploaded-files-list">
                    @foreach($sale->documents as $document)
                        <li class="mb-2 flex justify-between items-center">
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                               class="text-blue-600 dark:text-lime-400 hover:underline">
                                <i class="fa-solid fa-file mr-2"></i>{{ $document->name }}
                            </a>
                            @if(auth()->user()->hasRole('admin'))
                                <button type="button" class="text-red-600 dark:text-red-400 hover:underline ml-2"
                                        onclick="showConfirmationModal({{ $document->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $document->id }}"
                                      action="{{ route('sales.deleteDocument', [$sale->id, $document->id]) }}"
                                      method="POST" style="display:none;" onsubmit="disableConfirmButton(this)">
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
                    <form id="document-upload-form" action="{{ route('sales.addDocument', $sale->id) }}" method="POST"
                          enctype="multipart/form-data" class="flex flex-col items-start space-y-2" onsubmit="disableConfirmButton(this)">
                        @csrf
                        <ul id="selected-files-list" class="list-disc pl-5 text-gray-800 dark:text-gray-200"></ul>
                        <label for="documents"
                               class="cursor-pointer inline-flex items-center text-blue-600 dark:text-lime-400 hover:underline">
                            <i class="fa-solid fa-plus mr-2"></i>Adicionar Documento(s)
                        </label>
                        <input type="file" name="documents[]" id="documents" accept=".pdf,.jpg,.png,.doc,.docx" multiple
                               class="hidden" onchange="addSelectedFiles(event)">
                        <button type="submit"
                                class="bg-blue-600 dark:bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 dark:hover:bg-lime-600">
                            Upload
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Dados para Pagamento -->
    @if ($paymentStatus !== 'succeeded')
        <div class="mt-6 p-4 bg-blue-500 dark:bg-lime-500 text-gray-800 dark:text-gray-900 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-800">Dados para Pagamento</h2>
            <p><strong>Entidade:</strong> {{ $paymentEntity }}</p>
            <p><strong>Referência:</strong> {{ $paymentReference }}</p>
            <p><strong>Total a Pagar:</strong> {{ number_format($amount, 2) }} €</p>
            @if(isset($paymentVoucherUrl))
                <p><strong>Link de Pagamento:</strong> <a href="{{ $paymentVoucherUrl }}"
                                                          class="text-white underline inline-flex items-center"
                                                          target="_blank"><i class="fa-solid fa-receipt mr-2"></i>Ver
                        Link de Pagamento</a></p>
            @endif
            @if(isset($validity))
                <p><strong>Validade:</strong> {{ $validity }}</p>
            @endif
        </div>
    @else
        <div class="mt-6 p-4 bg-blue-500 dark:bg-lime-500 text-gray-800 dark:text-gray-900 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-800">Pagamento Concluído</h2>
            <p><a href="{{ $receiptUrl }}" class="text-white underline inline-flex items-center" target="_blank"><i
                        class="fa-solid fa-file-invoice-dollar mr-2"></i>Ver Comprovativo</a></p>
        </div>
    @endif
</div>

<!-- Modal de Confirmação -->
<div id="confirmation-modal"
     class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
        <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
        <div class="flex justify-end gap-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400"
                    onclick="cancelAction()">Cancelar
            </button>
            <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500"
                    onclick="confirmAction()">Confirmar
            </button>
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

    document.getElementById('document-upload-form').addEventListener('submit', function (event) {
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
