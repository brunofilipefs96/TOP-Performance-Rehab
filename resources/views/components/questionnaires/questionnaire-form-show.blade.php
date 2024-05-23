<div class="container mx-auto mt-5 pt-5 glass">
    <div class="flex justify-center mb-4">
        <button onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700">Voltar</button>
    </div>
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div>
                <h1 class="text-2xl mb-5 mt-3">{{$questionnaire->title}}</h1>
            </div>

            <div class="mb-4">
                <label for="description" class="block">Descrição</label>
                <textarea class="mt-1 block w-full p-2 border border-gray-300 text-gray-800 rounded-md shadow-sm" disabled>{{$questionnaire->description}}</textarea>
            </div>

            <hr/>
            <div class="mb-4 mt-5">
                <label for="questions" class="text-xl block mb-5">Perguntas do Questionário</label>
                    @php $questionNumber = 1; @endphp
                    @foreach($questionnaire->questions as $question)
                        <h4 class="text-lg mb-3 mt-2"> Pergunta nº {{$questionNumber++}}</h4>
                    <div class="mt-2 block w-full p-2 border border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm">
                            <p class="font-bold mb-2">{{$question->question_text}}</p>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>
