<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Category')" :description="__('Category management')" />
    <!-- Include Livewire Modal Component -->
    <livewire:category.category-modal />
    <div class="">
         <x-button.btn class="mb-4" wire:click="$dispatch('openCategoryModal')">
            {{ __('Add Category') }}
        </x-button.btn>

        <div class="">
            <x-table.table class="md:w-1/2">
                <x-table.thead>
                    <x-table.th>no</x-table.th>
                    <x-table.th>Category Name</x-table.th>
                    <x-table.th>action</x-table.th>
                </x-table.thead>
                <x-table.tbody>
                    @foreach($categories as $category)
                        <x-table.tr>
                            <x-table.td>{{ $loop->iteration }}</x-table.td>
                            <x-table.td>{{ $category->category_name }}</x-table.td>
                            <x-table.td> 
                               <x-button.btn type="button" color="blue" padding="px-3 py-1" 
                                    wire:click="$dispatch('openCategoryModal', { categoryId: {{ $category->id }} })">
                                    {{ __('Edit') }}
                                </x-button.btn>
                                <x-button.btn type="button" color="red" padding="px-3 py-1" 
                                    wire:click="deleteCategory({{ $category->id }})">
                                    {{ __('Delete') }}
                                </x-button.btn>
                            </x-table.td>  
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table.table>
        </div>
    </div>


</div>
@script
<script>
    Livewire.on('categorySaved', () => {
        // Reload categories after save
        @this.dispatch('categoriesUpdated');
    });
</script>
@endscript