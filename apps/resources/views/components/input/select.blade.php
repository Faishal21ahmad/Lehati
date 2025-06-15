@props([
    'name' => null,
    'type' => 'text',
    'id' => $name,
    'options' => [
        [
            'value' => '1',
            'label' => 'Option 1'
        ],
        [
            'value' => '2',
            'label' => 'Option 2'
        ],
        [
            'value' => '3',
            'label' => 'Option 3'
        ]
    ], 
    'label' => 'Your Label',
    'class' => null, 
    'placeholder' => 'Select an option', // More appropriate for select
    'required' => false, 
    'disabled' => false,
    'readonly' => false,
    'value' => null, // Added for preselected value
    'error' => null
])


<div class="mb-5 w-full">
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    
    <select 
        id="{{ $id }}"
        wire:model="{{ $name }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error($name) border-red-500 @enderror"
        
        @if($required) required @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
    >
        @if($placeholder)
            <option value="" disabled @if(!$value) selected @endif>{{ $placeholder }}</option>
        @endif
        
        @foreach($options as $option)
            <option 
                value="{{ $option['value'] }}" 
                @if( $option['value'] == $value) selected @endif
            >
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>
    
    
    @if($errors->has($name))
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>


