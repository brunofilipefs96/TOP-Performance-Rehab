@component('survey::questions.base', compact('question'))
    @foreach ($question->options as $option)
        <div class="custom-control custom-checkbox">
            <input type="checkbox"
                   name="{{ $question->key }}[]"
                   id="{{ $question->key . '-' . Str::slug($option) }}"
                   value="{{ $option }}"
                   class="custom-control-input text-blue-500 dark:text-lime-400   dark:bg-gray-600  dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500"
                    {{ ($value ?? old($question->key)) == $option ? 'checked' : '' }}
                    {{ ($disabled ?? false) ? 'disabled' : '' }}
            >
            <label class="custom-control-label text-gray-900 dark:text-white"
                   for="{{ $question->key . '-' . Str::slug($option) }}">{{ $option }}
            </label>
        </div>
    @endforeach
@endcomponent
