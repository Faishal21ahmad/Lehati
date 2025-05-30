@props([
    'icon' => null,
    'title' => 'Grub list',
    'active' => false,
    'badge' => null,
    'iconrow' => null
])

<li x-data="{ open: true }" class="relative">
    <button @click="open = !open" type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" >
        @if($icon)
            <x-dynamic-component 
                :component="'icon.' . $icon" 
                @class([
                    'w-5 h-5 transition duration-75',
                    'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' => !$active,
                    'text-white' => $active
                ])
            />
        @endif

        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $title }}</span>
        @if($iconrow)
        <x-dynamic-component 
            :component="'icon.' . $iconrow" 
            @class([
                'w-3 h-3 transition duration-75',
                'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' => !$active,
                'text-white' => $active
            ])
        />
        @endif

        </button>
    <ul class="py-2 space-y-2" x-show="open" x-transition>
        {{ $slot }}
    </ul>
</li>