@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm dark:text-gray-100']) }}>
    {{ $value ?? $slot }}
</label>
