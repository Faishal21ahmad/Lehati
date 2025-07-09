@props([
    'id' => null,
    'class' => 'w-full',
])

{{-- w-[90%] mx-auto --}}

<div id="search" class="lg:w-1/3 {{ $class }} ">
    <input 
        type="text" 
        wire:model.live.debounce.300ms="query" 
        id="simple-search" 
        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
        placeholder="Search room code, status, or product name..." 
    />
</div>