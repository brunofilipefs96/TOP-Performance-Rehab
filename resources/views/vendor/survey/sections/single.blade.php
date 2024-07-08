<h3 class="px-4 py-2 bg-gray-400 dark:bg-gray-700"> {{ $section->name }}</h3>
@foreach($section->questions as $question)
    @include('survey::questions.single')
@endforeach
