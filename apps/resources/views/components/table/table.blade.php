@props([
    'class' => 'w-full',
    'data' => [],
])

<div class="relative overflow-x-auto rounded-lg {{ $class }}">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        {{ $slot }}
    </table>
</div>