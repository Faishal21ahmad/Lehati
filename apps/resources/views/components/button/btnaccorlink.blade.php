@props([
    'href' => null,
    'color' => 'blue', // blue, red, green, gray, yellow
    'fullWidth' => false,
])

@php
    // Base classes
    $baseClasses = 'focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-4 py-2 text-center transition-colors hover:cursor-pointer';
    
    // Color variants
    $colorClasses = [
        'blue' => 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
        'red' => 'text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800',
        'green' => 'text-white bg-green-700 hover:bg-green-800 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
        'gray' => 'text-white bg-gray-700 hover:bg-gray-800 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800',
        'yellow' => 'text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-800',
    ][$color];
    
    // Width classes
    $widthClass = $fullWidth ? 'w-full' : '';
@endphp

<a  wire:navigate
    href="{{ $href ?? '#' }}"
    {{ $attributes->merge(['class' => "$baseClasses $colorClasses $widthClass "]) }}
>
    {{ $slot }}
</a>