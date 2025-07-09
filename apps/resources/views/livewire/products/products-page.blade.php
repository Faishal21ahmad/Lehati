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
                                @if ($product->status == 'sold')
                                    <span class="px-3 py-1 bg-red-500 rounded-full text-white font-semibold">Sold</span> 
                                @elseif ($product->status == 'use')
                                    <span class="px-3 py-1 bg-yellow-500 rounded-full text-white font-semibold">Use</span> 
                                @elseif ($product->status == 'available')
                                    <span class="px-3 py-1 bg-green-500 rounded-full text-white font-semibold">Available</span> 
                                @endif
                            </x-table.td>
                            <x-table.td class="flex md:flex-wrap gap-2"> 
                                <x-button.btnaccorlink href="{{ Route('product.edit', $product->id) }}" color="blue" padding="px-3 py-1">Detail</x-button.btnaccorlink>
                                <x-button.btn color="red" padding="px-3 py-1">Delete</x-button.btn>
                            </x-table.td>  
                        </x-table.tr>
                    @empty
                        <x-table.tr class="w-full">
                            <x-table.td colspan="5" class="text-center py-4">No products found</x-table.td>
                        </x-table.tr>
                    @endforelse
                



                   {{-- @foreach($products as $product)
                        <x-table.tr>
                            <x-table.td>{{ $loop->iteration }}</x-table.td>
                            <x-table.td>{{ $product->product_name }}</x-table.td>
                            <x-table.td>{{ $product->quantity }} {{ $product->units }}</x-table.td>
                            <x-table.td>{{ $product->status }}</x-table.td>
                            <x-table.td class="flex md:flex-wrap gap-2"> 
                                <x-button.btnaccorlink href="{{ Route('product.edit',$product->id) }}" color="blue" padding="px-3 py-1">Detail</x-button.btnaccorlink>
                                <x-button.btn color="red" padding="px-3 py-1">Delete</x-button.btn>
                            </x-table.td>  
                        </x-table.tr>
                    @endforeach --}}
                </x-table.tbody>
            </x-table.table>
            @if($products->hasPages())
                <div class="mt-4 lg:w-3/4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>