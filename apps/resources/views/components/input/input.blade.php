@props([
    'type' => null,
    'id' => null,
    'name' => $id,
    'value' => null, 
    'label' => 'Your Label',
    'class' => null, 
    'placeholder' => 'Enter here', 
    'required' => false, 
    'disabled' => false,
    'error' => null
])

<div class="mb-5 w-full">
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white {{ $errors->has($name) ? 'text-red-600 dark:text-red-500' : '' }}">
        {{ $label }}
    </label>
    <input 
        wire:model='{{ $name }}'
        type="{{ $type }}"
        id="{{ $id }}" 
        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 {{ $errors->has($name) ? 'border-red-500 bg-red-50 dark:bg-red-900/10' : '' }} {{ $class }}" 
        placeholder="{{ $placeholder }}"
        
        @if($required) required @endif
        @if($disabled) disabled @endif
    />
    @if($errors->has($name))
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>