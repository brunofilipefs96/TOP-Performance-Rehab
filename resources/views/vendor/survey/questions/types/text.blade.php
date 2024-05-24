@component('survey::questions.base', compact('question'))
    <div class="mt-3">
        <input type="text" name="{{ $question->key }}" id="{{ $question->key }}" class="form-control text-gray-900"
               value="{{ $value ?? old($question->key) }}" {{ ($disabled ?? false) ? 'disabled' : '' }}>
    </div>
@endcomponent
