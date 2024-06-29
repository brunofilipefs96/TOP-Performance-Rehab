<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Dashboard do Cliente</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
            @foreach ($products as $product)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <h2 class="text-lg text-gray-700 dark:text-gray-200 font-semibold">{{ $product->name }}</h2>
                    <p class="text-gray-700 dark:text-gray-200">{{ $product->description }}</p>
                    <p class="text-gray-700 dark:text-gray-200 font-bold">{{ $product->price }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
