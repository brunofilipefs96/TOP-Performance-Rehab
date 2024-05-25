@component('survey::questions.base', compact('question'))
    @foreach($question->options as $option)
        <div class="custom-control custom-radio mt-3">
            <input type="radio"
                   name="{{ $question->key }}"
                   id="{{ $question->key . '-' . Str::slug($option) }}"
                   value="{{ $option }}"
                   class="custom-control-input form-radio text-blue-500 dark:text-lime-400 h-4 w-4  dark:bg-gray-600  dark:focus:border-lime-400 dark:focus:ring-lime-400 dark:focus:ring-opacity-50 dark:checked:bg-lime-400 focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 checked:bg-blue-500"
                    {{ ($value ?? old($question->key)) == $option ? 'checked' : '' }}
                    {{ ($disabled ?? false) ? 'disabled' : '' }}
            >
            <label class="custom-control-label dark:text-white text-gray-800"
                   for="{{ $question->key . '-' . Str::slug($option) }}">{{ $option }}
                @if($includeResults ?? false)
                    <span class="text-success">
                        ({{ number_format((new \MattDaneshvar\Survey\Utilities\Summary($question))->similarAnswersRatio($option) * 100, 2) }}%)
                    </span>
                @endif
            </label>
        </div>
    @endforeach
@endcomponent
