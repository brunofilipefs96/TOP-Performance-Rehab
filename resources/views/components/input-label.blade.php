@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm dark:text-gray-100 text-gray-800']) }}>
    {{ $value ?? $slot }}
</label>
