<div class="card bg-gray-300 dark:bg-gray-800 p-4 rounded-2xl">
    <div class="card-header p-4">
        <h2 class="mb-2 font-extrabold text-xl dark:text-white text-gray-800">{{ $survey->name }}</h2>
        <hr class="dark:border-lime-400 w-40 border-blue-400">

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
        <div id="sections-container">
            @foreach($survey->sections as $section)
                <div class="section" data-section-id="{{ $section->id }}" style="display: none;">
                    @include('survey::sections.single', ['section' => $section])
                </div>
            @endforeach

            @foreach($survey->questions()->withoutSection()->get() as $question)
                @include('survey::questions.single')
            @endforeach
        </div>

        @if($eligible)
            <div class="navigation-buttons mt-4 mb-5">
                <button type="button" id="prev-button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900">Anterior</button>
                <button type="button" id="next-button" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900">Próximo</button>
                <button type="submit" id="submit-button" style="display: none;" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-400 dark:bg-lime-400 dark:hover:bg-lime-300 dark:text-gray-900">Enviar Formulário</button>
            </div>
        @endif
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentSectionIndex = 0;
        const sections = document.querySelectorAll('.section');
        const prevButton = document.getElementById('prev-button');
        const nextButton = document.getElementById('next-button');
        const submitButton = document.getElementById('submit-button');
        const sectionHistory = []; // Array to store section history

        function showSection(index) {
            sections.forEach((section, idx) => {
                section.style.display = (idx === index) ? 'block' : 'none';
            });

            prevButton.style.display = (index === 0) ? 'none' : 'inline-block';
            nextButton.style.display = (index === sections.length - 1) ? 'none' : 'inline-block';
            submitButton.style.display = (index === sections.length - 1) ? 'inline-block' : 'none';

            // Custom handling for section 10
            if (index === 9) {
                handleSection10();
            }
        }

        function clearErrors(section) {
            const errorMessages = section.querySelectorAll('.error-message');
            errorMessages.forEach(message => message.remove());
        }

        function showError(questionName, message) {
            const questionContainer = document.querySelector(`[name="${questionName}"]`).closest('.form-group');
            let errorDiv = questionContainer.querySelector('.text-danger');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'text-red-400 mt-3 error-message';
                questionContainer.appendChild(errorDiv);
            }
            errorDiv.textContent = message;
        }

        function validateSection(sectionIndex) {
            const section = sections[sectionIndex];
            clearErrors(section);

            const questions = section.querySelectorAll('input[type="radio"], input[type="checkbox"]');
            const groupedQuestions = {};

            // Agrupar perguntas por nome
            questions.forEach(question => {
                if (!groupedQuestions[question.name]) {
                    groupedQuestions[question.name] = [];
                }
                groupedQuestions[question.name].push(question);
            });

            let allAnswered = true;
            let allNo = true;

            // Verificar se todas as perguntas foram respondidas
            for (const questionName in groupedQuestions) {
                const questionGroup = groupedQuestions[questionName];
                const answered = questionGroup.some(q => q.checked);
                if (!answered) {
                    allAnswered = false;
                    showError(questionName, 'Esta pergunta é obrigatória.');
                } else {
                    // Verificar se todas as respostas são "não"
                    const selectedAnswer = questionGroup.find(q => q.checked);
                    if (selectedAnswer.value !== 'Não') {
                        allNo = false;
                    }
                }
            }

            // Custom validation for section 10
            if (sectionIndex === 9) {
                const selectedRadio = section.querySelector('input[type="radio"]:checked');
                const textBox = section.querySelector('input[type="text"]');
                if (selectedRadio && selectedRadio.value === 'Sim' && textBox.value.trim() === '') {
                    allAnswered = false;
                    showError(textBox.name, 'Esta pergunta é obrigatória.');
                }
            }

            return { allAnswered, allNo };
        }

        function handleSection2() {
            const section = sections[1]; // Assuming section 2 is at index 1
            const questions = section.querySelectorAll('input[type="radio"]');
            questions.forEach(question => {
                question.addEventListener('change', function () {
                    if (question.value === 'Não') {
                        nextButton.style.display = 'none';
                        submitButton.style.display = 'inline-block';
                    } else if (question.value === 'Sim') {
                        nextButton.style.display = 'inline-block';
                        submitButton.style.display = 'none';
                    }
                });
            });
        }

        function handleSection3() {
            const section = sections[2]; // Assuming section 3 is at index 2
            const questions = section.querySelectorAll('input[type="checkbox"]');
            questions.forEach(question => {
                question.addEventListener('change', function () {
                    const selected = Array.from(questions).some(q => q.checked);
                    if (selected) {
                        nextButton.style.display = 'inline-block';
                        submitButton.style.display = 'none';
                    } else {
                        nextButton.style.display = 'inline-block';
                        submitButton.style.display = 'none';
                    }
                });
            });
        }

        function getSection4Answer() {
            const section = sections[3]; // Assuming section 4 is at index 3
            const questions = section.querySelectorAll('input[type="radio"]');
            let selectedAnswer = null;
            questions.forEach(question => {
                if (question.checked) {
                    selectedAnswer = question.value;
                }
            });
            return selectedAnswer;
        }

        function handleSection5() {
            const section = sections[4]; // Assuming section 5 is at index 4
            const questions = section.querySelectorAll('input[type="checkbox"]');
            const noneOption = section.querySelector('input[value="Nenhuma"]');

            questions.forEach(question => {
                question.addEventListener('change', function () {
                    if (question.value === 'Nenhuma' && question.checked) {
                        questions.forEach(q => {
                            if (q !== question) {
                                q.checked = false;
                                q.disabled = true;
                            }
                        });
                    } else if (!question.checked && question.value === 'Nenhuma') {
                        questions.forEach(q => {
                            if (q !== question) {
                                q.disabled = false;
                            }
                        });
                    } else if (question.checked && question.value !== 'Nenhuma') {
                        noneOption.checked = false;
                        noneOption.disabled = false;
                    }
                });
            });
        }

        function getSection5Answer() {
            const section = sections[4]; // Assuming section 5 is at index 4
            const questions = section.querySelectorAll('input[type="checkbox"]');
            let selectedAnswer = null;
            questions.forEach(question => {
                if (question.checked) {
                    selectedAnswer = question.value;
                }
            });
            return selectedAnswer;
        }

        function handleSection7() {
            const section = sections[5]; // Assuming section 6 is at index 5
            const questions = section.querySelectorAll('input[type="radio"]');

            questions.forEach(question => {
                question.addEventListener('change', function () {
                    if (question.value === 'Não') {
                        nextButton.style.display = 'none';
                        submitButton.style.display = 'inline-block';
                    } else if (question.value === 'Sim') {
                        nextButton.style.display = 'inline-block';
                        submitButton.style.display = 'none';
                    }
                });
            });
        }

        function getSection7Answer() {
            const section = sections[5]; // Assuming section 6 is at index 5
            const questions = section.querySelectorAll('input[type="radio"]');
            let selectedAnswer = null;
            questions.forEach(question => {
                if (question.checked) {
                    selectedAnswer = question.value;
                }
            });
            return selectedAnswer;
        }

        // New function for handling Section 8 (index 7)
        function handleSection8() {
            const section = sections[7]; // Assuming section 8 is at index 7
            const questionGroups = section.querySelectorAll('.form-group');

            questionGroups.forEach(group => {
                const questions = group.querySelectorAll('input[type="checkbox"]');
                const noneOption = group.querySelector('input[value="Nenhum"]');

                questions.forEach(question => {
                    question.addEventListener('change', function () {
                        if (question.value === 'Nenhum' && question.checked) {
                            questions.forEach(q => {
                                if (q !== question) {
                                    q.checked = false;
                                    q.disabled = true;
                                }
                            });
                        } else if (!question.checked && question.value === 'Nenhum') {
                            questions.forEach(q => {
                                if (q !== question) {
                                    q.disabled = false;
                                }
                            });
                        } else if (question.checked && question.value !== 'Nenhum') {
                            noneOption.checked = false;
                            noneOption.disabled = false;
                        }
                    });
                });
            });
        }

        function handleSection10() {
            const section = sections[9]; // Assuming Section 10 is at index 9
            const radioButtons = section.querySelectorAll('input[type="radio"]');
            const textBox = section.querySelector('input[type="text"]');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (radio.value === 'Não') {
                        nextButton.style.display = 'none';
                        submitButton.style.display = 'inline-block';
                        textBox.required = false; // Remove the requirement
                        textBox.value = ''; // Clear the text box
                    } else if (radio.value === 'Sim') {
                        nextButton.style.display = 'inline-block';
                        submitButton.style.display = 'none';
                        textBox.required = true; // Make the text box required
                    }
                });
            });

            textBox.addEventListener('input', function () {
                if (textBox.value.trim() !== '') {
                    nextButton.style.display = 'inline-block';
                    submitButton.style.display = 'none';
                } else {
                    nextButton.style.display = 'none';
                    submitButton.style.display = 'inline-block';
                }
            });
        }

        nextButton.addEventListener('click', function () {
            const validation = validateSection(currentSectionIndex);
            if (!validation.allAnswered) {
                return;
            }

            sectionHistory.push(currentSectionIndex); // Add current section to history

            if (currentSectionIndex === 0) { // Se estamos na seção 1
                if (validation.allNo) {
                    currentSectionIndex = 2; // Pular para a seção 3
                } else {
                    currentSectionIndex = 1; // Avançar para a seção 2
                    handleSection2();
                }
            } else if (currentSectionIndex === 1) {
                // Se estamos na seção 2, as respostas serão tratadas por handleSection2()
                return;
            } else if (currentSectionIndex === 2) {
                handleSection3();
                currentSectionIndex = 3; // Avançar para a seção 4 se houver
            } else if (currentSectionIndex === 3) {
                const section4Answer = getSection4Answer();
                if (section4Answer === 'Sim') {
                    currentSectionIndex = 4; // Ir para a seção 5
                    handleSection5();
                } else if (section4Answer === 'Não') {
                    currentSectionIndex = 6; // Ir para a seção 7
                }
            } else if (currentSectionIndex === 4) { // Se estamos na seção 5
                const section5Answer = getSection5Answer();
                if (section5Answer === 'Nenhuma') {
                    currentSectionIndex = 6; // Ir para a seção 7
                } else {
                    currentSectionIndex = 5; // Ir para a seção 6
                    handleSection7();
                }
            } else if (currentSectionIndex === 5) { // Se estamos na seção 6
                const section7Answer = getSection7Answer();
                if (section7Answer === 'Não') {
                    nextButton.style.display = 'none';
                    submitButton.style.display = 'inline-block';
                } else if (section7Answer === 'Sim') {
                    currentSectionIndex = 6; // Ir para a seção 7
                }
            } else if (currentSectionIndex === 6) { // Se estamos na seção 7
                handleSection8();
                currentSectionIndex = 7; // Avançar para a seção 8
            } else if (currentSectionIndex === 9) { // Se estamos na seção 10
                handleSection10();
                currentSectionIndex = 10; // Avançar para a seção 11
            } else {
                currentSectionIndex++;
            }

            showSection(currentSectionIndex);
        });

        prevButton.addEventListener('click', function () {
            if (sectionHistory.length > 0) {
                currentSectionIndex = sectionHistory.pop(); // Retrieve last visited section
            } else if (currentSectionIndex === 2) { // Se estamos na seção 3
                currentSectionIndex = 0; // Voltar para a seção 1
            } else {
                currentSectionIndex--;
            }
            showSection(currentSectionIndex);
        });

        showSection(currentSectionIndex);
    });
</script>
