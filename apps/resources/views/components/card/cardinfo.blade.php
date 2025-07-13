@props([
    'value' => '0',
    'label' => 'Your Label',
])

<div class="w-full h-40 flex flex-col gap-5 bg-white dark:bg-gray-800 p-3 items-center text-center justify-center rounded-md shadow-sm">
    <p class="text-4xl font-bold">{{ $value }}</p>
    <span class="text-lg">{{ $label }}</span>
</div>