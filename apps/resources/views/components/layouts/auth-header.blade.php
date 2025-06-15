@props([
    'title' => '',
    'description' => '',
    'icon' => 'none', // icon name from icon component
])

<div class="mb-5">
    <div class="flex w-full max-w-md mx-auto mb-4 justify-center">
        <x-dynamic-component 
        :component="'icon.' . $icon" 
        @class([
            'transition duration-75 w-15 h-15',
            'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white '
        ])
    />
    </div>
    <h1 class="text-center text-2xl font-semibold whitespace-nowrap dark:text-white my-5">{{ $title }}</h1>
    <p class="text-gray-500 dark:text-gray-300">{{ $description }}</p>
</div>