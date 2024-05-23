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
            <form method="POST" action="{{ url('users.memberships.questionnaires.storeForm')}}">
                @csrf
                <div class="mb-4 mt-5">
                    <label for="questions" class="text-xl block mb-5">Perguntas do Questionário</label>
                    @php $questionNumber = 1; @endphp
                    @foreach($questionnaire->questions as $question)
                        <h4 class="text-lg mb-3 mt-2"> Pergunta nº {{$questionNumber++}}</h4>
                        <div class="mt-2 block w-full p-2 border border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm">
                            <p class="font-bold mb-2">{{$question->question_text}}</p>
                            <input type="hidden" name="answers[{{$question->id}}][question_id]" value="{{ $question->id }}">

                            @if($question->questionType->name === 'multiple_questions')
                                <div class="mb-2">
                                    <input type="radio" id="response_1_{{ $question->id }}" name="answers[{{$question->id}}][response]" value="1">
                                    <label for="response_1_{{ $question->id }}">1</label>
                                </div>
                                <div class="mb-2">
                                    <input type="radio" id="response_2_{{ $question->id }}" name="answers[{{$question->id}}][response]" value="2">
                                    <label for="response_2_{{ $question->id }}">2</label>
                                </div>
                                <div class="mb-2">
                                    <input type="radio" id="response_3_{{ $question->id }}" name="answers[{{$question->id}}][response]" value="3">
                                    <label for="response_3_{{ $question->id }}">3</label>
                                </div>
                                <div class="mb-2">
                                    <input type="radio" id="response_4_{{ $question->id }}" name="answers[{{$question->id}}][response]" value="4">
                                    <label for="response_4_{{ $question->id }}">4</label>
                                </div>
                                <div class="mb-2">
                                    <input type="radio" id="response_5_{{ $question->id }}" name="answers[{{$question->id}}][response]" value="5">
                                    <label for="response_5_{{ $question->id }}">5</label>
                                </div>
                            @elseif($question->questionType->name === 'boolean')
                                <div class="mb-2">
                                    <input type="radio" id="response_yes_{{ $question->id }}" name="answers[{{$question->id}}][response]" value="yes">
                                    <label for="response_yes_{{ $question->id }}">Sim</label>
                                </div>
                                <div class="mb-2">
                                    <input type="radio" id="response_no_{{ $question->id }}" name="answers[{{$question->id}}][response]" value="no">
                                    <label for="response_no_{{ $question->id }}">Não</label>
                                </div>
                            @elseif($question->questionType->name === 'single_question')
                                <div class="mb-2">
                                    <textarea id="response_{{ $question->id }}" name="answers[{{$question->id}}][response]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-500"></textarea>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="mt-4 mb-5 w-full bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700">Enviar Respostas</button>
            </form>
        </div>
    </div>
</div>
