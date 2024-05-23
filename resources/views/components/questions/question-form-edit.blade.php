<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <form method="POST" action="{{ route('questions.update', $question->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <h1 class="text-xl font-bold text-gray-200">Editar Pergunta</h1>
                    <hr class="border-t border-gray-300">
                </div>

                <div class="mb-4">
                    <label for="question_text" class="block text-sm font-medium text-gray-200">Texto da Pergunta</label>
                    <textarea id="question_text"
                              name="question_text"
                              autocomplete="question_text"
                              placeholder="Escreva a pergunta"
                              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-500
                              @error('question_text') border-red-500 @enderror"
                              required
                              aria-describedby="questionTextHelp">{{ $question->question_text }}</textarea>
                    @error('question_text')
                    <span class="text-red-500 text-sm mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="mt-4 mb-5 w-full bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700">Atualizar</button>
            </form>
        </div>
    </div>
</div>
