@props([
    'title' => null,
    'name' => null,
    'options' => [],
    'gridCols' => 'md:grid-cols-2',
    'error' => null,
    'helpText' => null
    'error' => null
])

<div class="mb-5">
    @if($title)
        <h3 class="mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $title }}</h3>
    @endif
    
    <ul class="grid w-full gap-4 {{ $gridCols }}">
        @foreach($options as $option)
            <x-input.radio-button
                name="{{ $name }}"
                id="{{ $name }}_{{ $option['value'] }}"
                value="{{ $option['value'] }}"
                label="{{ $option['label'] }}"
                wire:model="{{ $name }}"
                :checked="$option['checked'] ?? false"
                :disabled="$option['disabled'] ?? false"
            />
        @endforeach
    </ul>
    
    @if($helpText && !$errors->has($name))
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $helpText }}
        </p>
    @endif
    
    @if($errors->has($name))
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>