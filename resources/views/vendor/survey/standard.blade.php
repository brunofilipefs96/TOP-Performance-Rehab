<div class="card bg-gray-300 dark:bg-gray-800 p-4 rounded-2xl">
    <div class="card-header p-4">
        <h2 class="mb-2 font-extrabold text-xl dark:text-white text-gray-800">{{ $survey->name }}</h2>
        <hr class="dark:border-lime-400 w-40 border-blue-400">

        @if(!$eligible)\
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
                <button type="submit" class="mt-4 mb-5 bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900">Enviar Formulário</button>
        @endif
    @endif
</div>
