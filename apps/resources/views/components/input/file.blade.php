@props([
    'id' => null,
    'name' => $id,
    'label' => 'Upload file',
    'multiple' => false,
    'accept' => null, // e.g. 'image/*', '.pdf,.docx', etc
    'disabled' => false,
    'class' => null,
    'helpText' => null,
])

<div class="mb-5 w-full {{ $class }}">
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="{{ $id }}">
        {{ $label }}
        {{-- @if($required) <span class="text-red-500">*</span> @endif --}}
    </label>
    
    <input 
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 overflow-auto"
        id="{{ $id }}"
        {{-- name="{{ $name }}" --}}
        wire:model='{{ $name }}'
        type="file"
        {{-- autocomplete="{{ $name }}" --}}
        @if($multiple) multiple @endif
        @if($accept) accept="{{ $accept }}" @endif
        @if($disabled) disabled @endif
    >
    
    @if($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">{{ $helpText }}</p>
    @endif
    
    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">
            {{ $message }}
        </p>
    @enderror
    
    @if($multiple)
        @error("$name.*")
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                {{ $message }}
            </p>
        @enderror
    @endif
</div>