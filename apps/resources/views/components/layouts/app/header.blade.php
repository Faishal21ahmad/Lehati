@props([
    'title' => 'Your Page Title',
    'description' => 'Your page description goes here.',
])

<div class="p-4 border-b border-gray-300 dark:border-gray-600 mb-2">
    <h1 class="mb-2 text-md font-semibold">{{ $title }}</h1>
    <span class="text-gray-500 dark:text-gray-300">{{ $description }}</span>
</div>