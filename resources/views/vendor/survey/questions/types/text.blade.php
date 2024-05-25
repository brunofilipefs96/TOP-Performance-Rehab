@component('survey::questions.base', compact('question'))
    <div class="mt-3">
        <input type="text" name="{{ $question->key }}" id="{{ $question->key }}" class="form-control text-gray-900 rounded-xl dark:text-white dark:bg-gray-600 border-gray-300 border dark:border-gray-600 dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50"
               value="{{ $value ?? old($question->key) }}" {{ ($disabled ?? false) ? 'disabled' : '' }}>
    </div>
@endcomponent
