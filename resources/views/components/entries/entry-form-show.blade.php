<div class="card bg-gray-300 dark:bg-gray-800 p-4 rounded-2xl">
    <div class="card-header p-4">
        <h2 class="mb-2 font-extrabold text-xl dark:text-white text-gray-800">{{ $entry->survey->name }}</h2>
        <hr class="dark:border-lime-400 w-40 border-blue-400">
    </div>
    @if(!$entry->survey->acceptsGuestEntries() && auth()->guest())
        <div class="p-5">
            Please login to join this survey.
        </div>
    @else
        <div id="sections-container">
            @foreach($entry->survey->sections as $index => $section)
                <div class="section p-4 bg-gray-800 rounded-md my-4" data-section-index="{{ $index }}" style="{{ $index > 0 ? 'display:none;' : '' }}">
                    <h3 class="px-4 py-2 bg-gray-800" style="border-top:solid 1px #dadada">{{ $section->name }}</h3>
                    @foreach($section->questions as $question)
                        <div class="p-4">
                            <div class="form-group">
                                <label style="font-size:1.1rem" class="mb-3 dark:text-white text-gray-800" for="{{ $question->key }}">{{ $question->content }}</label>
                                @php
                                    $answer = $entry->answers->where('question_id', $question->id)->first();
                                @endphp
                                @if($question->type == 'multiselect' && $answer && !is_null($answer->value))
                                    @php
                                        $selectedOptions = explode(', ', $answer->value);
                                    @endphp
                                    @foreach ($question->options as $option)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                   name="{{ $question->key }}[]"
                                                   id="{{ $question->key . '-' . Str::slug($option) }}"
                                                   value="{{ $option }}"
                                                   class="custom-control-input"
                                                   {{ in_array($option, $selectedOptions) ? 'checked' : '' }}
                                                   disabled>
                                            <label class="custom-control-label"
                                                   for="{{ $question->key . '-' . Str::slug($option) }}">{{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif($question->type == 'radio' && $answer && !is_null($answer->value))
                                    @foreach ($question->options as $option)
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                   name="{{ $question->key }}"
                                                   id="{{ $question->key . '-' . Str::slug($option) }}"
                                                   value="{{ $option }}"
                                                   class="custom-control-input"
                                                   {{ $answer->value == $option ? 'checked' : '' }}
                                                   disabled>
                                            <label class="custom-control-label"
                                                   for="{{ $question->key . '-' . Str::slug($option) }}">{{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif($answer && !is_null($answer->value))
                                    <div class="mt-3">
                                        <input type="{{ $question->type }}" name="{{ $question->key }}" id="{{ $question->key }}" class="form-control text-gray-900 rounded-xl dark:text-white dark:bg-gray-600 border-gray-300 border dark:border-gray-600"
                                               value="{{ $answer->value }}" disabled>
                                        <label> @if($question->type == 'radio'){{ $answer->value }}@endif</label>
                                    </div>
                                @else
                                    <p class="text-gray-500">Esta pergunta não foi respondida.</p>
                                @endif
                            </div>
                            @if($errors->has($question->key))
                                <div class="text-danger mt-3">{{ $errors->first($question->key) }}</div>
                            @endif
                            <div class="text-success">
                                @if($question->type == 'number' && $answer && !is_null($answer->value))
                                    {{ number_format((new \MattDaneshvar\Survey\Utilities\Summary($question))->average()) }} (Average)
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            @foreach($entry->survey->questions()->withoutSection()->get() as $question)
                <div class="p-4">
                    <div class="form-group">
                        <label style="font-size:1.1rem" class="mb-3 dark:text-white text-gray-800" for="{{ $question->key }}">{{ $question->content }}</label>
                        @php
                            $answer = $entry->answers->where('question_id', $question->id)->first();
                        @endphp
                        @if($question->type == 'multiselect' && $answer && !is_null($answer->value))
                            @php
                                $selectedOptions = explode(', ', $answer->value);
                            @endphp
                            @foreach ($question->options as $option)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           name="{{ $question->key }}[]"
                                           id="{{ $question->key . '-' . Str::slug($option) }}"
                                           value="{{ $option }}"
                                           class="custom-control-input"
                                           {{ in_array($option, $selectedOptions) ? 'checked' : '' }}
                                           disabled>
                                    <label class="custom-control-label"
                                           for="{{ $question->key . '-' . Str::slug($option) }}">{{ $option }}
                                    </label>
                                </div>
                            @endforeach
                        @elseif($question->type == 'radio' && $answer && !is_null($answer->value))
                            @foreach ($question->options as $option)
                                <div class="custom-control custom-radio">
                                    <input type="radio"
                                           name="{{ $question->key }}"
                                           id="{{ $question->key . '-' . Str::slug($option) }}"
                                           value="{{ $option }}"
                                           class="custom-control-input"
                                           {{ $answer->value == $option ? 'checked' : '' }}
                                           disabled>
                                    <label class="custom-control-label"
                                           for="{{ $question->key . '-' . Str::slug($option) }}">{{ $option }}
                                    </label>
                                </div>
                            @endforeach
                        @elseif($answer && !is_null($answer->value))
                            <div class="mt-3">
                                <input type="{{ $question->type }}" name="{{ $question->key }}" id="{{ $question->key }}" class="form-control text-gray-900 rounded-xl dark:text-white dark:bg-gray-600 border-gray-300 border dark:border-gray-600"
                                       value="{{ $answer->value }}" disabled>
                            </div>
                        @else
                            <p class="text-gray-500">Esta pergunta não foi respondida.</p>
                        @endif
                    </div>
                    @if($errors->has($question->key))
                        <div class="text-danger mt-3">{{ $errors->first($question->key) }}</div>
                    @endif
                    <div class="text-success">
                        @if($question->type == 'number' && $answer && !is_null($answer->value))
                            {{ number_format((new \MattDaneshvar\Survey\Utilities\Summary($question))->average()) }} (Average)
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="navigation-buttons mt-4 mb-5 flex justify-between">
            @if($user->membership && $user->membership->id > 0)
                @if($user->hasRole('admin'))
                    <a href="{{ url('memberships/' . $user->membership->id) }}" class="bg-red-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-red-400 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900">Sair</a>
                @else
                    <a href="{{ url()->previous() }}" class="bg-red-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-red-400 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900">Sair</a>
                @endif
            @endif
            <div>
                <button type="button" id="prev-button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900">Anterior</button>
                <button type="button" id="next-button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900 ml-2">Próximo</button>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentSectionIndex = 0;
        const sections = document.querySelectorAll('.section');
        const prevButton = document.getElementById('prev-button');
        const nextButton = document.getElementById('next-button');

        function showSection(index) {
            sections.forEach((section, idx) => {
                section.style.display = (idx === index) ? 'block' : 'none';
            });

            prevButton.style.display = (index === 0) ? 'none' : 'inline-block';
            nextButton.style.display = (index === sections.length - 1) ? 'none' : 'inline-block';
        }

        prevButton.addEventListener('click', function () {
            if (currentSectionIndex > 0) {
                currentSectionIndex--;
                showSection(currentSectionIndex);
            }
        });

        nextButton.addEventListener('click', function () {
            if (currentSectionIndex < sections.length - 1) {
                currentSectionIndex++;
                showSection(currentSectionIndex);
            }
        });

        showSection(currentSectionIndex);
    });
</script>
