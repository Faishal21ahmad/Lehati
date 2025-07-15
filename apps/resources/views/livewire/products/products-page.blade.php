<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Products')" :description="__('Manage Your Product ')" />
    <div class="">
        <div class="flex gap-2 items-center mb-2">
            <x-button.btnaccorlink navigate=true href="{{ route('product.create') }}">
                {{ __('Add Product') }}
            </x-button.btnaccorlink>
            <x-input.search id="search" class="w-3/5" />
        </div>
        <div class="">
            <x-table.table class="lg:w-3/4">
                <x-table.thead>
                    <x-table.th>no</x-table.th>
                    <x-table.th>Product Name</x-table.th>
                    <x-table.th>Quantity</x-table.th>
                    <x-table.th>status</x-table.th>
                    <x-table.th>action</x-table.th>
                </x-table.thead>
                <x-table.tbody>
                    @forelse($products as $product)
                        <x-table.tr>
                            <x-table.td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</x-table.td>
                            <x-table.td>{{ $product->product_name }}</x-table.td>
                            <x-table.td>{{ $product->quantity }} {{ $product->units }}</x-table.td>
                            <x-table.td>
                                <span @class([
                                    'px-3 py-1 rounded-full text-white font-semibold',
                                    'bg-red-500' => $product->status === 'sold',
                                    'bg-yellow-500' => $product->status === 'use',
                                    'bg-green-500' => $product->status === 'available',
                                ])>
                                    {{ Str::title($product->status) }}
                                </span>
                            </x-table.td>
                            <x-table.td class="flex md:flex-wrap gap-2"> 
                                <x-button.btnaccorlink href="{{ Route('product.edit', $product->id) }}" color="blue" padding="px-3 py-1">Detail</x-button.btnaccorlink>
                                <x-button.btn 
                                wire:click="confirmDelete({{ $product->id }})" 
                                color="red" padding="px-3 py-1">Delete</x-button.btn>
                            </x-table.td>  
                        </x-table.tr>
                    @empty
                        <x-table.tr class="w-full">
                            <x-table.td colspan="5" class="text-center py-4">No products found</x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-table.tbody>
            </x-table.table>
            @if($products->hasPages())
                <div class="mt-4 lg:w-3/4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>


    <!-- Modal Konfirmasi Delete -->
    @if($showModal)
    <x-modal.modal-confrim
        message="Are you sure you want to delete this product {{ $produk }} ?"
        confirmMethod="delete"
    />
    @endif

</div>


