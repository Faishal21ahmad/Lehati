@props([
    'title' => 'Your Page Title',
    'description' => 'Your page description goes here.',
])

<div class="">
    <h1 class="mb-2 text-sm font-semibold">{{ $title }}</h1>
    <span class="text-sm text-gray-500 dark:text-gray-300">{{ $description }}</span>
</div>