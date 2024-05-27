@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'dark:border-gray-300  dark:border-gray-700 dark:bg-gray-400 dark:text-gray-900 text-gray-800 focus:border-blue-500 dark:focus:border-lime-600 focus:ring-blue-500 dark:focus:ring-lime-600 rounded-md shadow-sm']) !!}>
