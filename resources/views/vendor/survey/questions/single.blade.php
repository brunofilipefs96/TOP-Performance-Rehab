<div class="p-4">
    @if(view()->exists("survey::questions.types.{$question->type}"))
        @include("survey::questions.types.{$question->type}", [
            'disabled' => !($eligible ?? true),
            'value' => $lastEntry ? $lastEntry->answerFor($question) : null,
            'includeResults' => ($lastEntry ?? null) !== null
        ])
    @else
        @include("survey::questions.types.text", [
            'disabled' => !($eligible ?? true),
            'value' => $lastEntry ? $lastEntry->answerFor($question) : null,
            'includeResults' => ($lastEntry ?? null) !== null
        ])
    @endif
</div>
