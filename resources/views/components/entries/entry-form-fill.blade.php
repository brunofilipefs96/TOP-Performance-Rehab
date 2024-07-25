<div class="container mx-auto mt-10 pt-5 glass">
    <form method="POST" action="{{ route('entries.store', $survey->id) }}" onsubmit="disableConfirmButton(this)">
        @csrf
        @include('survey::standard', ['survey' => $survey])
    </form>
</div>


