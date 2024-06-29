<style>
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    .accordion-item.active .accordion-content {
        max-height: 500px; /* Adjust as needed */
    }
    .category-button {
        transition: background-color 0.3s, transform 0.3s;
    }
    .category-button:hover {
        background-color: #4b5563; /* Adjust hover background color */
        transform: scale(1.05);
    }
    .category-button:active {
        background-color: #1f2937; /* Adjust active background color */
        transform: scale(0.95);
    }
    .active-category {
        background-color: #4b5563; /* Adjust active category background color */
        color: white;
    }
    .dark .active-category {
        background-color: #4b5563; /* Adjust active category background color */
        color: white;
    }
</style>

<body>

<div class="max-w-6xl mx-auto p-6 mt-5">
    <h1 class="text-3xl font-bold text-center mb-8 dark:text-white text-gray-900">Frequently Asked Questions</h1>

    <!-- Category Filter for Mobile -->
    <div class="block lg:hidden mb-4">
        <select id="mobile-category-filter" class="w-full p-2 bg-gray-600 rounded" onchange="filterCategory(this.value)">
            <option value="all" class="dark:bg-gray-400 bg-gray-500">All</option>
            <option value="workouts" class="dark:bg-gray-400 bg-gray-500">Workouts</option>
            <option value="products" class="dark:bg-gray-400 bg-gray-500">Products</option>
            <option value="services" class="dark:bg-gray-400 bg-gray-500">Services</option>
        </select>
    </div>

    <div class="flex flex-col lg:flex-row lg:space-x-8">
        <!-- Category Filter for Desktop -->
        <div class="hidden lg:block w-1/4 dark:bg-gray-700 bg-gray-300 p-4 rounded-lg shadow-md h-80 overflow-y-auto">
            <h2 class="text-xl font-medium mb-4 text-gray-600 dark:text-white">Categories</h2>
            <ul id="category-list">
                <li class="mb-2"><button class="w-full text-left p-2 dark:bg-gray-800 bg-gray-400 rounded category-button" onclick="filterCategory('all')">All</button></li>
                <li class="mb-2"><button class="w-full text-left p-2 dark:bg-gray-800 bg-gray-400 rounded category-button" onclick="filterCategory('workouts')">Workouts</button></li>
                <li class="mb-2"><button class="w-full text-left p-2 dark:bg-gray-800 bg-gray-400 rounded category-button" onclick="filterCategory('products')">Products</button></li>
                <li class="mb-2"><button class="w-full text-left p-2 dark:bg-gray-800 bg-gray-400 rounded category-button" onclick="filterCategory('services')">Services</button></li>
            </ul>
        </div>

        <div id="faq-container" class="w-full lg:w-3/4 space-y-4">
            <!-- Accordion Item 1 -->
            <div class="accordion-item dark:bg-gray-800 bg-gray-400 rounded-lg shadow-md p-4" data-category="products">
                <div class="accordion-header cursor-pointer flex justify-between items-center" onclick="toggleAccordion(event)">
                    <h2 class="text-lg font-medium">What is your return policy?</h2>
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </div>
                <div class="accordion-content mt-4 dark:text-lime-400 text-gray-900">
                    <p>Our return policy allows for returns within 30 days of purchase with a receipt. Items must be in original condition.</p>
                </div>
            </div>

            <!-- Accordion Item 2 -->
            <div class="accordion-item dark:bg-gray-800 bg-gray-400 rounded-lg shadow-md p-4" data-category="services">
                <div class="accordion-header cursor-pointer flex justify-between items-center" onclick="toggleAccordion(event)">
                    <h2 class="text-lg font-medium">How do I track my order?</h2>
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </div>
                <div class="accordion-content mt-4 dark:text-lime-400 text-gray-900">
                    <p>You can track your order using the tracking number provided in your shipping confirmation email.</p>
                </div>
            </div>

            <!-- Accordion Item 3 -->
            <div class="accordion-item dark:bg-gray-800 bg-gray-400 rounded-lg shadow-md p-4" data-category="products">
                <div class="accordion-header cursor-pointer flex justify-between items-center" onclick="toggleAccordion(event)">
                    <h2 class="text-lg font-medium">Do you offer gift cards?</h2>
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </div>
                <div class="accordion-content mt-4 dark:text-lime-400 text-gray-900">
                    <p>Yes, we offer gift cards in various denominations. You can purchase them online or in-store.</p>
                </div>
            </div>

            <!-- Accordion Item 4 -->
            <div class="accordion-item dark:bg-gray-800 bg-gray-400 rounded-lg shadow-md p-4" data-category="workouts">
                <div class="accordion-header cursor-pointer flex justify-between items-center" onclick="toggleAccordion(event)">
                    <h2 class="text-lg font-medium">What is the best way to start a workout routine?</h2>
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </div>
                <div class="accordion-content mt-4 dark:text-lime-400 text-gray-900">
                    <p>Starting with a balanced routine that includes cardio, strength training, and flexibility exercises is best. Gradually increase intensity.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAccordion(event) {
        const item = event.currentTarget.parentElement;
        item.classList.toggle('active');
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

        const activeButton = Array.from(buttons).find(button => button.textContent.trim().toLowerCase() === category);
        if (activeButton) {
            activeButton.classList.add('active-category');
        } else {
            buttons[0].classList.add('active-category'); // Default to "All" if no match
        }
    }
</script>
