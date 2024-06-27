<div class="container mx-auto mt-10 pt-5 glass">
    <div class="flex justify-center mb-8">
        <div class="w-full max-w-2xl relative">
            <div class="progress-steps">
                <span class="step complete">
                    <span class="number"><i class="fa-solid fa-check"></i></span>
                    <span class="text">Morada</span>
                    <span class="spacer"></span>
                </span>
                <span class="step complete">
                    <span class="number"><i class="fa-solid fa-check"></i></span>
                    <span class="text">Matrícula</span>
                    <span class="spacer"></span>
                </span>
                <span class="step active">
                    <span class="number"><i class="fa-solid fa-check"></i></span>
                    <span class="text">Modalidades</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number">4</span>
                    <span class="text">Seguro</span>
                    <span class="spacer"></span>
                </span>
                <span class="step">
                    <span class="number">5</span>
                    <span class="text last">Pagamento</span>
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($trainingTypes as $trainingType)
                            <label class="selectable-item mb-4 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600" data-id="{{ $trainingType->id }}">
                                <p class="block text-gray-800 dark:text-gray-200">{{ $trainingType->name }}</p>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('setup.membershipShow') }}"
                           class="inline-block bg-gray-500 py-3 px-8 rounded-md shadow-sm hover:bg-gray-700 text-white text-lg">
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Restaurar seleções do localStorage
        document.querySelectorAll('.selectable-item').forEach((label) => {
            const trainingId = label.dataset.id;
            if (localStorage.getItem(`training-selected-${trainingId}`) === 'true') {
                label.classList.add('selected');
            }

            // Adicionar evento de clique para guardar a seleção
            label.addEventListener('click', (event) => {
                if (label.classList.contains('selected')) {
                    label.classList.remove('selected');
                    localStorage.setItem(`training-selected-${trainingId}`, false);
                } else {
                    label.classList.add('selected');
                    localStorage.setItem(`training-selected-${trainingId}`, true);
                }
            });
        });
    });
</script>

<style>
    .selectable-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem; /* Reduced padding */
        border-radius: 9999px;
        background-color: #e5e7eb;
        border: 1px solid #d1d5db;
        transition: transform 0.2s, background-color 0.2s;
        cursor: pointer;
    }

    .selectable-item.selected {
        background-color: #a3e635; /* Change this to your desired color when selected */
    }

    .selectable-item.selected p {
        color: #000; /* Change text color to black when selected */
    }

    .selectable-item:hover {
        transform: scale(1.02);
        background-color: #d1d5db;
    }

    .selectable-item p {
        pointer-events: none;
    }
</style>
