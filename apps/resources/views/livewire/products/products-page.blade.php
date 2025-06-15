<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Products')" :description="__('Manage Your Product ')" />

    <div class="">
        <x-button.btnaccorlink class="mb-4" href="{{ route('product.create') }}">
            {{ __('Add Product') }}
        </x-button.btnaccorlink>

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
                   @foreach($products as $product)
                        <x-table.tr>
                            <x-table.td>{{ $loop->iteration }}</x-table.td>
                            <x-table.td>{{ $product->product_name }}</x-table.td>
                            <x-table.td>{{ $product->quantity }} {{ $product->unit }}</x-table.td>
                            <x-table.td>{{ $product->status }}</x-table.td>
                            <x-table.td> 
                                <x-button.btnaccorlink href="{{ Route('product.detail',$product->id) }}" color="blue" padding="px-3 py-1">Detail</x-button.btnaccorlink>
                                <x-button.btn color="red" padding="px-3 py-1">Delete</x-button.btn>
                            </x-table.td>  
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table.table>
        </div>
    </div>
</div>