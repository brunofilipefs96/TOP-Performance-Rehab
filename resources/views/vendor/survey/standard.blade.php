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
                <button type="button" id="exit-button" style="display: none;" class="bg-red-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-red-400 dark:bg-red-400 dark:hover:bg-red-300 dark:text-gray-900">Sair</button>
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
        const exitButton = document.getElementById('exit-button'); // Novo botão de saída
        const sectionHistory = [];

        function showSection(index) {
            sections.forEach((section, idx) => {
                section.style.display = (idx === index) ? 'block' : 'none';
            });

            prevButton.style.display = (index === 0) ? 'none' : 'inline-block';
            nextButton.style.display = (index === sections.length - 1) ? 'none' : 'inline-block';
            submitButton.style.display = (index === sections.length - 1) ? 'inline-block' : 'none';

            if (index === 3) { // Chamando handleSection4 ao entrar na quarta seção
                handleSection4();
            }

            if (index === 4) { // Chamando handleSection5 ao entrar na quinta seção
                handleSection5();
            }

            if (index === 5) { // Chamando handleSection6 ao entrar na sexta seção
                handleSection6();
            }

            if (index === 6) { // Chamando handleSection7 ao entrar na sétima seção
                handleSection7();
            }

            if (index === 7) { // Chamando handleSection8 ao entrar na oitava seção
                handleSection8();
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

            questions.forEach(question => {
                if (!groupedQuestions[question.name]) {
                    groupedQuestions[question.name] = [];
                }
                groupedQuestions[question.name].push(question);
            });

            let allAnswered = true;
            let allNo = true;

            for (const questionName in groupedQuestions) {
                const questionGroup = groupedQuestions[questionName];
                const answered = questionGroup.some(q => q.checked);
                if (!answered) {
                    allAnswered = false;
                    showError(questionName, 'Esta pergunta é obrigatória.');
                } else {
                    const selectedAnswer = questionGroup.find(q => q.checked);
                    if (selectedAnswer.value !== 'Não') {
                        allNo = false;
                    }
                }
            }

            if (sectionIndex === 3) { // Custom validation for section 4
                const selectedRadio = section.querySelector('input[type="radio"]:checked');
                const textBox = section.querySelector('input[type="text"]');
                if (selectedRadio && selectedRadio.value === 'Sim' && textBox.value.trim() === '') {
                    allAnswered = false;
                    showError(textBox.name, 'Esta pergunta é obrigatória.');
                }
            }

            if (sectionIndex === 4) { // Custom validation for section 5
                const selectedRadio = section.querySelector('input[type="radio"]:checked');
                const textBox = section.querySelector('input[type="text"]');
                if (selectedRadio && selectedRadio.value === 'Sim' && textBox.value.trim() === '') {
                    allAnswered = false;
                    showError(textBox.name, 'Esta pergunta é obrigatória.');
                }
            }

            if (sectionIndex === 5) { // Custom validation for section 6
                const selectedRadio = section.querySelector('input[type="radio"]:checked');
                const textBox = section.querySelector('input[type="text"]');
                if (selectedRadio && selectedRadio.value === 'Sim' && textBox.value.trim() === '') {
                    allAnswered = false;
                    showError(textBox.name, 'Esta pergunta é obrigatória.');
                }
            }

            if (sectionIndex === 6) { // Custom validation for section 7
                const selectedRadio = section.querySelector('input[type="radio"]:checked');
                const textBox = section.querySelector('input[type="text"]');
                if (selectedRadio && selectedRadio.value === 'Sim' && textBox.value.trim() === '') {
                    allAnswered = false;
                    showError(textBox.name, 'Esta pergunta é obrigatória.');
                }
            }

            if (sectionIndex === 7) { // Custom validation for section 8
                const selectedRadio1 = section.querySelectorAll('input[type="radio"]:checked')[0];
                const textBox2 = section.querySelectorAll('input[type="text"]')[0];
                const selectedRadio3 = section.querySelectorAll('input[type="radio"]:checked')[1];
                const textBox4 = section.querySelectorAll('input[type="text"]')[1];

                alert(selectedRadio1);
                alert(textBox2);

                if (selectedRadio1 && selectedRadio1.value === 'Sim' && textBox2.value.trim() === '') {
                    allAnswered = false;
                    showError(textBox2.name, 'Esta pergunta é obrigatória.');
                }
                if (selectedRadio3 && selectedRadio3.value === 'Sim' && textBox4.value.trim() === '') {
                    allAnswered = false;
                    showError(textBox4.name, 'Esta pergunta é obrigatória.');
                }

                const errorMessage = section.querySelector('.error-message');
                if (!allAnswered && errorMessage) {
                    errorMessage.style.display = 'block';
                }
            }

            return { allAnswered, allNo };
        }

        function handleSection2() {
            const section = sections[1];
            const questions = section.querySelectorAll('input[type="radio"]');
            questions.forEach(question => {
                question.addEventListener('change', function () {
                    if (question.value === 'Não') {
                        nextButton.style.display = 'none';
                        submitButton.style.display = 'none'; // Oculta o botão de enviar
                        exitButton.style.display = 'inline-block'; // Mostra o botão de saída
                    } else if (question.value === 'Sim') {
                        nextButton.style.display = 'inline-block';
                        submitButton.style.display = 'none';
                        exitButton.style.display = 'none'; // Oculta o botão de saída
                    }
                });
            });

            // Adiciona a funcionalidade de redirecionamento ao botão "Sair"
            exitButton.addEventListener('click', function () {
                window.location.href = '{{ route('memberships.create') }}';
            });
        }

        function handleSection4() {
            const section = sections[3]; // Assuming the fourth section is at index 3
            const multiselectQuestions = section.querySelectorAll('input[type="checkbox"]');

            multiselectQuestions.forEach(question => {
                question.addEventListener('change', function () {
                    const questionGroup = document.querySelectorAll(`input[name="${question.name}"]`);
                    const noneOption = Array.from(questionGroup).find(q => q.value === 'Nenhum');

                    if (question.checked && question.value === 'Nenhum') {
                        questionGroup.forEach(q => {
                            if (q !== question) {
                                q.checked = false;
                                q.disabled = true;
                            }
                        });
                    } else {
                        noneOption.checked = false;
                        questionGroup.forEach(q => q.disabled = false);
                    }
                });
            });

            const radioButtons = section.querySelectorAll('input[type="radio"]');
            const textBox = section.querySelector('input[type="text"]');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (radio.value === 'Sim') {
                        textBox.required = true;
                    } else {
                        textBox.required = false;
                        textBox.value = '';
                    }
                });
            });
        }

        function handleSection5() {
            const section = sections[4]; // Assuming the fifth section is at index 4
            const multiselectQuestions = section.querySelectorAll('input[type="checkbox"]');

            multiselectQuestions.forEach(question => {
                question.addEventListener('change', function () {
                    const questionGroup = document.querySelectorAll(`input[name="${question.name}"]`);
                    const noneOption = Array.from(questionGroup).find(q => q.value === 'Nenhum');

                    if (question.checked && question.value === 'Nenhum') {
                        questionGroup.forEach(q => {
                            if (q !== question) {
                                q.checked = false;
                                q.disabled = true;
                            }
                        });
                    } else {
                        noneOption.checked = false;
                        questionGroup.forEach(q => q.disabled = false);
                    }
                });
            });

            const radioButtons = section.querySelectorAll('input[type="radio"]');
            const textBox = section.querySelector('input[type="text"]');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (radio.value === 'Sim') {
                        textBox.required = true;
                    } else {
                        textBox.required = false;
                        textBox.value = '';
                    }
                });
            });
        }

        function handleSection6() {
            const section = sections[5]; // Assuming the sixth section is at index 5
            const radioButtons = section.querySelectorAll('input[type="radio"]');
            const textBox = section.querySelector('input[type="text"]');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (radio.value === 'Sim') {
                        textBox.required = true;
                        nextButton.style.display = 'inline-block';
                        submitButton.style.display = 'none';
                    } else if (radio.value === 'Não') {
                        textBox.required = false;
                        textBox.value = '';
                        nextButton.style.display = 'none';
                        submitButton.style.display = 'inline-block';
                    }
                });
            });
        }

        function handleSection7() {
            const section = sections[6]; // Assuming the seventh section is at index 6
            const radioButtons = section.querySelectorAll('input[type="radio"]');
            const textBox = section.querySelector('input[type="text"]');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (radio.value === 'Sim') {
                        textBox.required = true;
                    } else {
                        textBox.required = false;
                        textBox.value = '';
                    }
                });
            });
        }

        function handleSection8() {
            const section = sections[7]; // Assuming the eighth section is at index 7
            const radioButton1 = section.querySelectorAll('input[type="radio"]')[0];
            const textBox1 = section.querySelectorAll('input[type="text"]')[0];
            const radioButton2 = section.querySelectorAll('input[type="radio"]')[1];
            const textBox2 = section.querySelectorAll('input[type="text"]')[1];

            alert(radioButton1);
            alert(textBox1);

            radioButton1.addEventListener('change', function () {
                if (radioButton1.value === 'Sim') {
                    textBox1.required = true;
                } else {
                    textBox1.required = false;
                    textBox1.value = '';
                }
            });

            radioButton2.addEventListener('change', function () {
                if (radioButton2.value === 'Sim') {
                    textBox2.required = true;
                } else {
                    textBox2.required = false;
                    textBox2.value = '';
                }
            });
        }

        submitButton.addEventListener('click', function (event) {
            const validation = validateSection(currentSectionIndex);
            if (!validation.allAnswered) {
                event.preventDefault();
                if (currentSectionIndex === 7) { // Only show error for section 8
                    const section = sections[7];
                    const errorMessage = section.querySelector('.error-message');
                    if (errorMessage) {
                        errorMessage.style.display = 'block';
                    }
                }
            }
        });

        nextButton.addEventListener('click', function () {
            const validation = validateSection(currentSectionIndex);
            if (!validation.allAnswered) {
                if (currentSectionIndex === 7) { // Only show error for section 8
                    const section = sections[7];
                    const errorMessage = section.querySelector('.error-message');
                    if (errorMessage) {
                        errorMessage.style.display = 'block';
                    }
                }
                return;
            }

            sectionHistory.push(currentSectionIndex);

            if (currentSectionIndex === 0) {
                if (validation.allNo) {
                    currentSectionIndex = 2;
                } else {
                    currentSectionIndex = 1;
                    handleSection2();
                }
            } else if (currentSectionIndex === 1) {
                currentSectionIndex = 2; // Avançar para a seção 3
            } else {
                currentSectionIndex++;
            }

            if (currentSectionIndex === 7 && validation.allAnswered) {
                nextButton.style.display = 'none';
                submitButton.style.display = 'inline-block';
            }

            showSection(currentSectionIndex);
        });

        prevButton.addEventListener('click', function () {
            if (sectionHistory.length > 0) {
                currentSectionIndex = sectionHistory.pop();
            } else if (currentSectionIndex === 2) {
                currentSectionIndex = 0;
            } else {
                currentSectionIndex--;
            }
            showSection(currentSectionIndex);
        });

        showSection(currentSectionIndex);
    });
</script>
