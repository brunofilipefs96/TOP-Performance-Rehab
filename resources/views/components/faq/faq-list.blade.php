<style>

    .accordion-content {

        max-height: 0;

        overflow: hidden;

        transition: max-height 0.3s ease;

    }

    .accordion-item.active .accordion-content {

        max-height: 500px; /* Ajustar conforme necessário */

    }

    .category-button {

        transition: background-color 0.3s, transform 0.3s;

    }

    .category-button:hover {

        background-color: #4b5563; /* Ajustar cor de fundo ao passar o mouse */

        transform: scale(1.05);

    }

    .category-button:active {

        background-color: #1f2937; /* Ajustar cor de fundo ao clicar */

        transform: scale(0.95);

    }

    .active-category {

        background-color: #68ed09; /* Ajustar cor de fundo da categoria ativa */

        color: white;

    }

    .dark .active-category {

        background-color: #68ed09; /* Ajustar cor de fundo da categoria ativa */

        color: white;

    }

</style>


<body>

<div class="max-w-6xl mx-auto p-6 mt-5">
    <h1 class="text-3xl font-bold text-center mb-8 dark:text-white text-gray-900">Perguntas Frequentes</h1>

    <!-- Filtro de Categoria para Mobile -->
    <div class="block lg:hidden mb-4">
        <select id="mobile-category-filter" class="w-full p-2 bg-gray-600 rounded" onchange="filterCategory(this.value)">
            <option value="all" class="dark:bg-gray-400 bg-gray-500">Todos</option>
            <option value="workouts" class="dark:bg-gray-400 bg-gray-500">Treinos</option>
            <option value="products" class="dark:bg-gray-400 bg-gray-500">Produtos</option>
            <option value="services" class="dark:bg-gray-400 bg-gray-500">Serviços</option>
        </select>
    </div>

    <div class="flex flex-col lg:flex-row lg:space-x-8">
        <!-- Filtro de Categoria para Desktop -->
        <div class="hidden lg:block w-1/4 dark:bg-gray-700 bg-gray-300 p-4 rounded-lg shadow-md h-80 overflow-y-auto">
            <h2 class="text-xl font-medium mb-4 text-gray-600 dark:text-white">Categorias</h2>
            <ul id="category-list">
                <li class="mb-2"><button class="w-full text-left p-2 dark:bg-gray-800 bg-gray-400 rounded category-button" onclick="filterCategory('all')">Todos</button></li>
                <li class="mb-2"><button class="w-full text-left p-2 dark:bg-gray-800 bg-gray-400 rounded category-button" onclick="filterCategory('workouts')">Treinos</button></li>
                <li class="mb-2"><button class="w-full text-left p-2 dark:bg-gray-800 bg-gray-400 rounded category-button" onclick="filterCategory('products')">Produtos</button></li>
                <li class="mb-2"><button class="w-full text-left p-2 dark:bg-gray-800 bg-gray-400 rounded category-button" onclick="filterCategory('services')">Serviços</button></li>
            </ul>
        </div>

        <div id="faq-container" class="w-full lg:w-3/4 space-y-4">
            <!-- Item de Acordeão 1 -->
            <div class="accordion-item dark:bg-gray-800 bg-gray-400 rounded-lg shadow-md p-4" data-category="services">
                <div class="accordion-header cursor-pointer flex justify-between items-center" onclick="toggleAccordion(event)">
                    <h2 class="text-lg font-medium">Como funciona o processo de inscrição?</h2>
                    <svg class="w-6 h-6 text-gray-500 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </div>
                <div class="accordion-content mt-4 dark:text-lime-400 text-gray-900">
                    <p>Para se inscrever, você precisa preencher o formulário de inscrição disponível no nosso site. Após o envio, você terá de aguardar pela aprovação de um administrador.</p>
                </div>
            </div>

            <!-- Item de Acordeão 2 -->
            <div class="accordion-item dark:bg-gray-800 bg-gray-400 rounded-lg shadow-md p-4" data-category="workouts">
                <div class="accordion-header cursor-pointer flex justify-between items-center" onclick="toggleAccordion(event)">
                    <h2 class="text-lg font-medium">Quais tipos de treinos vocês oferecem?</h2>
                    <svg class="w-6 h-6 text-gray-500 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </div>
                <div class="accordion-content mt-4 dark:text-lime-400 text-gray-900">
                    <p>Oferecemos uma variedade de treinos, incluindo PT Individual, PT Duo (dois clientes), PT Trio (três clientes), PT Individual de Eletroestimulação, PT Individual de Pilates e Treino Funcional. Os nossos treinos são projetados para diferentes níveis de condicionamento físico.</p>
                </div>
            </div>

            <!-- Item de Acordeão 3 -->
            <div class="accordion-item dark:bg-gray-800 bg-gray-400 rounded-lg shadow-md p-4" data-category="products">
                <div class="accordion-header cursor-pointer flex justify-between items-center" onclick="toggleAccordion(event)">
                    <h2 class="text-lg font-medium">Como posso acompanhar minha encomenda?</h2>
                    <svg class="w-6 h-6 text-gray-500 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </div>
                <div class="accordion-content mt-4 dark:text-lime-400 text-gray-900">
                    <p>Você pode acompanhar a sua encomenda usando o número de rastreamento fornecido no e-mail de confirmação de envio.</p>
                </div>
            </div>

            <!-- Item de Acordeão 4 -->
            <div class="accordion-item dark:bg-gray-800 bg-gray-400 rounded-lg shadow-md p-4" data-category="products">
                <div class="accordion-header cursor-pointer flex justify-between items-center" onclick="toggleAccordion(event)">
                    <h2 class="text-lg font-medium">Como posso agendar uma avaliação física?</h2>
                    <svg class="w-6 h-6 text-gray-500 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </div>
                <div class="accordion-content mt-4 dark:text-lime-400 text-gray-900">
                    <p>Para agendar uma avaliação física terá de entrar em contacto com o ginásio para verificar a disponibilidade.</p>
                </div>
            </div>

            <!-- Item de Acordeão 5 -->
            <div class="accordion-item dark:bg-gray-800 bg-gray-400 rounded-lg shadow-md p-4" data-category="workouts">
                <div class="accordion-header cursor-pointer flex justify-between items-center" onclick="toggleAccordion(event)">
                    <h2 class="text-lg font-medium">Como devo começar uma rotina de treinos?</h2>
                    <svg class="w-6 h-6 text-gray-500 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </div>
                <div class="accordion-content mt-4 dark:text-lime-400 text-gray-900">
                    <p>O melhor é começar com uma rotina equilibrada que inclua exercícios cardiovasculares, de força e de flexibilidade. Aumente a intensidade gradualmente.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAccordion(event) {
        const item = event.currentTarget.parentElement;
        const icon = event.currentTarget.querySelector('.accordion-icon');
        item.classList.toggle('active');
        icon.classList.toggle('rotate-180');
    }

    function filterCategory(category) {
        const items = document.querySelectorAll('.accordion-item');
        const buttons = document.querySelectorAll('.category-button');

        items.forEach(item => {
            if (category === 'all' || item.getAttribute('data-category') === category) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });

        buttons.forEach(button => {
            button.classList.remove('active-category');
        });

        const activeButton = Array.from(buttons).find(button => {
            return button.textContent.trim().toLowerCase() === category.toLowerCase();
        });

        if (activeButton) {
            activeButton.classList.add('active-category');
            if (document.documentElement.classList.contains('dark')) {
                activeButton.style.backgroundColor = '#32CD32'; // bg-lime-400
            } else {
                activeButton.style.backgroundColor = '#1E90FF'; // bg-blue-400
            }
        }
    }

    // Seleciona a categoria "Todos" por padrão ao carregar a página
    document.addEventListener('DOMContentLoaded', () => {
        filterCategory('all');
    });
</script>

</body>
