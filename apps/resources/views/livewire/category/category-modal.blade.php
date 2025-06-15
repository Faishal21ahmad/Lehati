<div x-data="{ isOpen: @entangle('isOpen') }">
    <!-- Modal Backdrop -->
    <div x-show="isOpen" x-cloak
        @click="isOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <!-- Modal Content - Mencegah event click merambat ke backdrop -->
        <div x-show="isOpen" x-cloak
            @click.stop
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-800">
            
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $categoryId ? 'Edit Category' : 'Add Category' }}
                </h3>
                <button @click="isOpen = false" type="button" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4">
                <div class="mb-4">
                    <x-input.input type="text" id="category_name" name="category_name" placeholder="Enter category name" label="Category Name" required error="{{ $errors->first('category_name') }}"/>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center justify-end p-4 border-t dark:border-gray-700 gap-2">
                <x-button.btn type="button" class="" wire:click="closeModal" color="gray">Cancel</x-button.btn>
                <x-button.btn type="button" class="" wire:click="save" color="blue">Save</x-button.btn>
            </div>
        </div>
    </div>
</div>