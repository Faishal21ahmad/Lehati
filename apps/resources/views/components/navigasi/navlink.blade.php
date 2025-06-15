@props([
    'href' => '#',
    'icon' => 'none',
    'active' => false,
    'badge' => null
])

    <a 
        wire:navigate
        href="{{ $href ?? '#' }}"
        {{-- @click.prevent="window.Livewire.navigate('{{ $link }}')" --}}
        type="button"
        {{ $attributes->class([
            'flex items-center p-2 rounded-lg group w-full text-left',
            'text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700' => !$active,
            'text-white bg-blue-600 dark:bg-blue-700' => $active
        ]) }}
    >
        @if($icon === 'none')
            <span class=""></span>
        @elseif($icon)
            <x-dynamic-component 
                :component="'icon.' . $icon" 
                @class([
                    'w-5 h-5 transition duration-75',
                    'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' => !$active,
                    'text-white' => $active
                ])
            />
        @endif
        
        <span class="ms-3">{{ $slot }}</span>
        
        @if($badge)
            <span @class([
                'inline-flex items-center justify-center px-2 ms-3 text-sm font-medium rounded-full',
                'text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-300' => !$active,
                'text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-300' => $active
            ])>
                {{ $badge }}
            </span>
        @endif
    </a>
