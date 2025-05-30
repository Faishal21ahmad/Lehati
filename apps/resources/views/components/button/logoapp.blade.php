@props([
    'href' => 'home',
    'icon' => 'none',
    'title' => 'Logo App',
    'size' => 'medium', // small, medium, large
])

@php
    $sizelogo = [
        'small' => 'w-7 h-7',
        'medium' => 'w-8 h-8',
        'large' => 'w-10 h-10',
    ][$size] ?? '';

    $sizefont = [
        'small' => 'text-lg',
        'medium' => 'text-xl',
        'large' => 'text-2xl',
    ][$size] ?? '';
    
@endphp

<a  
    wire:navigate.hover
    href="{{ $href }}" 
    class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
    <x-dynamic-component 
        :component="'icon.' . $icon" 
        @class([
            'transition duration-75' . $sizelogo,
            'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white '
        ])
    />
    <span class="font-semibold {{ $sizefont }}">{{ $title }}</span>
</a>