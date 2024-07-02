<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">1</span>
                    <span class="text text-gray-900 dark:text-white">Morada</span>
                    <span class="spacer"></span>
                </span>
                <span class="step complete">
                    <span class="number text-gray-900 dark:text-white">2</span>
                    <span class="text text-gray-900 dark:text-white">Matrícula</span>
                    <span class="spacer"></span>
                </span>
                <span class="step active">
                    <span class="number text-gray-900 dark:text-white">3</span>
                    <span class="text text-gray-900 dark:text-white">Modalidades</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">4</span>
                    <span class="text text-gray-900 dark:text-white">Seguro</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number text-gray-900 dark:text-white">5</span>
                    <span class="text last text-gray-900 dark:text-white">Pagamento</span>
                </span>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-4xl bg-gray-300 dark:bg-gray-800 p-6 rounded-2xl shadow-sm relative">
            <div class="flex flex-col items-center">
                <div class="w-full">
                    <div>
                        <h1 class="mb-8 text-3xl text-gray-900 dark:text-lime-400">Modalidades</h1>
                    </div>

                    <form method="POST" action="{{ route('setup.storeTrainingTypes') }}" id="trainingTypesForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($trainingTypes as $trainingType)
                                <label class="selectable-item mb-4 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 {{ in_array($trainingType->id, $userTrainingTypes) ? 'selected locked' : '' }}" data-id="{{ $trainingType->id }}">
                                    <p class="block text-gray-800 dark:text-gray-200">{{ $trainingType->name }}</p>
                                    <input type="hidden" name="trainingTypes[]" value="{{ $trainingType->id }}" {{ in_array($trainingType->id, $userTrainingTypes) ? '' : 'disabled' }}>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center mt-6 gap-2">
                            <a href="{{ route('setup.membershipShow') }}"
                               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 font-semibold flex items-center text-sm mt-4 mb-5 shadow-sm w-full justify-center max-w-[100px]">
                                <i class="fa-solid fa-arrow-left w-4 h-4 mr-2"></i>
                                Voltar
                            </a>
                            <div class="flex gap-2 items-center">
                                <a href="{{ route('setup.insuranceShow') }}" id="advanceButton" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]" style="display: none;">
                                    Avançar
                                    <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                                </a>
                                <button type="submit" id="submitButton" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400 dark:bg-lime-500 dark:hover:bg-lime-400 dark:hover:text-gray-800 font-semibold flex items-center text-sm w-full justify-center max-w-[150px]">
                                    Avançar
                                    <i class="fa-solid fa-arrow-right w-4 h-4 ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const hasLockedItems = document.querySelectorAll('.selectable-item.locked').length > 0;

        if (hasLockedItems) {
            document.querySelectorAll('.selectable-item').forEach((label) => {
                label.classList.add('locked');
            });
            document.getElementById('submitButton').style.display = 'none';
            document.getElementById('advanceButton').style.display = 'flex';
        } else {
            document.querySelectorAll('.selectable-item').forEach((label) => {
                label.addEventListener('click', (event) => {
                    const input = label.querySelector('input');
                    if (label.classList.contains('selected')) {
                        label.classList.remove('selected');
                        input.disabled = true;
                    } else {
                        label.classList.add('selected');
                        input.disabled = false;
                    }
                });
            });
            document.getElementById('submitButton').style.display = 'flex';
            document.getElementById('advanceButton').style.display = 'none';
        }
    });
</script>

<style>
    .selectable-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-radius: 9999px;
        background-color: #e5e7eb;
        border: 1px solid #d1d5db;
        transition: transform 0.2s, background-color 0.2s;
        cursor: pointer;
    }

    .selectable-item.selected {
        background-color: #3b82f6; /* Azul no modo claro */
    }

    .dark .selectable-item.selected {
        background-color: #84cc16; /* Lime no modo escuro */
    }

    .selectable-item.selected p {
        color: #000; /* Cor do texto preta quando selecionado */
    }

    /* Manter a cor ao passar o mouse quando selecionado */
    .selectable-item.selected:hover {
        background-color: #3b82f6; /* Manter azul no modo claro */
    }

    .dark .selectable-item.selected:hover {
        background-color: #84cc16; /* Manter lime no modo escuro */
    }

    .selectable-item:hover {
        transform: scale(1.02);
        background-color: #9CA3AF; /* Cinza do botão "Voltar" no modo claro */
    }

    .dark .selectable-item:hover {
        background-color: #d1d5db; /* Mantém o mesmo comportamento no modo escuro */
    }

    .selectable-item p {
        pointer-events: none;
    }

    .locked {
        cursor: not-allowed;
        opacity: 0.6;
        pointer-events: none;
    }
</style>
