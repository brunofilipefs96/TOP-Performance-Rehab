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
                        <h1 class="mb-8 text-3xl text-gray-900 dark:text-lime-400">Tipos de Treinamento</h1>
                    </div>

                    @foreach ($trainingTypes as $trainingType)
                        <label class="selectable-item mb-8 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                            <p class="block text-gray-800 dark:text-gray-200">{{ $trainingType->name }}</p>
                            <input type="checkbox" class="custom-checkbox">
                        </label>
                    @endforeach

                    <div class="flex justify-end mt-6">
                        <a href="{{ url('/setup') }}"
                           class="inline-block bg-gray-500 py-3 px-8 rounded-md shadow-sm hover:bg-gray-700 text-white text-lg">
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-checkbox {
        appearance: none;
        background-color: #fff;
        border: 2px solid #ccc;
        border-radius: 50%;
        width: 1.5em;
        height: 1.5em;
        cursor: pointer;
        position: relative;
        transition: border-color 0.2s ease-in-out, background-color 0.2s ease-in-out;
        outline: none;
    }

    .custom-checkbox:checked {
        background-color: #fff;
        border-color: #ccc;
    }

    .custom-checkbox:checked::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 1em;
        height: 1em;
        background-color: #a3e635;
        border-radius: 50%;
    }

    .selectable-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        border-radius: 9999px;
        background-color: #e5e7eb;
        border: 1px solid #d1d5db;
        transition: transform 0.2s, background-color 0.2s;
        cursor: pointer;
    }

    .selectable-item:hover {
        transform: scale(1.02);
        background-color: #d1d5db;
    }

    .selectable-item input {
        pointer-events: none;
    }
</style>
