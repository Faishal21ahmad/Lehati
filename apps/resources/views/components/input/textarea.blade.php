@props([
    'id' => null,
    'name' => $id,
    'value' => null, 
    'label' => 'Your Label',
    'class' => null, 
    'placeholder' => 'Write your thoughts here...', 
    'disabled' => false,
    'error' => null
])
<div class="mb-5 w-full">
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    <textarea 
        id="{{ $id }}" 
        rows="4" 
        wire:model='{{ $name }}'
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
        placeholder="{{ $placeholder }}"
        autocomplete="{{ $name }}"
        @if($disabled) disabled @endif
        ></textarea>
    @if($errors->has($name))
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>