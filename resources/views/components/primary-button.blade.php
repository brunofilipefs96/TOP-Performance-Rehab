<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-lime-600 hover:bg-lime-500 dark:bg-lime-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-lime-800 uppercase tracking-widest dark:hover:bg-lime-300 dark:focus:bg-lime-400  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-lime-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
