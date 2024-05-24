@component('survey::questions.base', compact('question'))
    <div class="mt-3">
        <input type="number" name="{{ $question->key }}" id="{{ $question->key }}" class="form-control text-gray-900"
               value="{{ $value ?? old($question->key) }}" {{ ($disabled ?? false) ? 'disabled' : '' }}>

        @slot('report')
            @if($includeResults ?? false)
                {{ number_format((new \MattDaneshvar\Survey\Utilities\Summary($question))->average()) }} (Average)
            @endif
        @endslot
    </div>
@endcomponent
