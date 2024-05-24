<div class="card bg-white dark:bg-gray-700 p-4">
    <div class="card-header p-4">
        <h2 class="mb-0">{{ $survey->name }}</h2>

        @if(!$eligible)
            We only accept
            <strong>{{ $survey->limitPerParticipant() }} {{ \Str::plural('entry', $survey->limitPerParticipant()) }}</strong>
            per participant.
        @endif

        @if($lastEntry)
            You last submitted your answers <strong>{{ $lastEntry->created_at->diffForHumans() }}</strong>.
        @endif

    </div>
    @if(!$survey->acceptsGuestEntries() && auth()->guest())
        <div class="p-5">
            Please login to join this survey.
        </div>
    @else
        @foreach($survey->sections as $section)
            @include('survey::sections.single')
        @endforeach

        @foreach($survey->questions()->withoutSection()->get() as $question)
            @include('survey::questions.single')
        @endforeach

        @if($eligible)
                <button type="submit" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900">Enviar Formulário</button>
        @endif
    @endif
</div>
