<div class="card bg-gray-300 dark:bg-gray-800 p-4 rounded-2xl">
    <div class="card-header p-4">
        <h2 class="mb-2 font-extrabold text-xl dark:text-white text-gray-800">{{ $survey->name }}</h2>
        <hr class="dark:border-lime-400 w-40 border-blue-400">


    </div>
        <div id="sections-container">
            @foreach($survey->sections as $section)
                <div class="section" data-section-id="{{ $section->id }}" style="display: none;">
                    @include('survey::sections.single', ['section' => $section, 'entry' => $entry])
                </div>
            @endforeach

            @foreach($survey->questions()->withoutSection()->get() as $question)
                @include('survey::questions.single', ['entry' => $entry])
            @endforeach
        </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentSectionIndex = 0;
        const sections = document.querySelectorAll('.section');

        function showSection(index) {
            sections.forEach((section, idx) => {
                section.style.display = (idx === index) ? 'block' : 'none';
            });
        }

        function disableInputs() {
            const inputs = document.querySelectorAll('input, select, textarea, button');
            inputs.forEach(input => {
                input.disabled = true;
            });
        }

        disableInputs();
        showSection(currentSectionIndex);
    });
</script>

