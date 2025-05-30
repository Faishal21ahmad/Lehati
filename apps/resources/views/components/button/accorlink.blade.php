@props([
    'href' => null,
    'color' => 'blue', // blue, red, green, gray, yellow
])

@php
    // Base classes
    $baseClasses = ' font-medium rounded-lg text-sm transition-colors hover:cursor-pointer hover:underline';
    
    // Color variants
    $colorClasses = [
        'blue' => 'text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-500',
        'red' => 'text-red-600 dark:text-red-500 hover:text-red-800 dark:hover:text-red-600',
        'green' => 'text-green-600 dark:text-green-500 hover:text-green-800 dark:hover:text-green-600',
        'gray' => 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100',
        'yellow' => 'text-yellow-400 dark:text-yellow-400 hover:text-yellow-500 dark:hover:text-yellow-500',
    ][$color];
    
    // Width classes
    
@endphp

<a  wire:navigate
    href="{{ $href ?? '#' }}"
    {{ $attributes->merge(['class' => "$baseClasses $colorClasses "]) }}
>
    {{ $slot }}
</a>