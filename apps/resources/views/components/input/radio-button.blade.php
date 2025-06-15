@props([
    'name' => null,
    'id' => null,
    'value' => null,
    'label' => 'Option',
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'helpText' => null,
    'gridCols' => 'md:grid-cols-2' // Default 2 columns
    'error' => null
])

<li>
    <input 
        wire:model="{{ $name }}"
        type="radio"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($checked) checked @endif
        @if($required) required @endif
        @if($disabled) disabled @endif
        class="hidden peer"
    />
    <label 
        for="{{ $id }}" 
        class="inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
    >
        <div class="block w-full text-center">
            <div class="w-full text-sm">{{ $label }}</div>
        </div>
    </label>
</li>