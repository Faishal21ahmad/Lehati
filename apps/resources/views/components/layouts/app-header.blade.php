@props([
    'title' => 'Your Page Title',
    'description' => 'Your page description goes here.',
])

<div class=" mb-2">
    <h1 class="mb-2 text-xl text-md font-semibold">{{ $title }}</h1>
    <span class="text-md text-gray-500 dark:text-gray-300">{{ $description }}</span>
    <div class="mt-5 border-1 border-gray-300 dark:border-gray-600 rounded-full"></div>
</div>