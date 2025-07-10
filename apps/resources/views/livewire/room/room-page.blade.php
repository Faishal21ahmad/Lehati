<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Rooms')" :description="__('Your Room Partisipan')" />
    <div class="flex flex-col gap-2">
        <x-input.search id="search"  />
        <x-table.table class="lg:w-3/4">
            <x-table.thead>
                <x-table.th>no</x-table.th>
                <x-table.th>Room</x-table.th>
                <x-table.th>Status Room</x-table.th>
                <x-table.th>Product</x-table.th>
                <x-table.th>Status Partisipan</x-table.th>
                <x-table.th>action</x-table.th>
            </x-table.thead>
            <x-table.tbody>
                @forelse($partisipans as $partisipan)
                    <x-table.tr>
                        <x-table.td>{{ $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $partisipan->room->room_code }}</x-table.td>
                        <x-table.td>
                            <span @class(['rounded-full text-white px-3 py-1',
                                'bg-red-700' => $partisipan->room->status === 'cancelled',
                                'bg-yellow-700' => $partisipan->room->status === 'upcoming',
                                'bg-green-700' => $partisipan->room->status === 'ongoing',
                                'bg-gray-700' => $partisipan->room->status === 'ended',
                            ])>
                                {{ Str::title($partisipan->room->status) }}
                            </span>
                        </x-table.td>
                        <x-table.td>{{ $partisipan->room->product->product_name }}</x-table.td>
                        <x-table.td>
                            <span @class(['rounded-full text-white px-3 py-1',
                                'bg-red-700' => $partisipan->status === 'rejected',
                                'bg-green-700' => $partisipan->status === 'joined',
                                'bg-gray-700' => $partisipan->status === 'left',
                            ])>
                                {{ Str::title($partisipan->status) }}
                            </span>
                        </x-table.td>
                        <x-table.td class="flex md:flex-wrap gap-2"> 
                            @if($partisipan->status == 'joined')
                                <x-button.btnaccorlink href="{{ Route('room.detail', $partisipan->room->room_code) }}" color="blue" padding="px-3 py-1">Detail</x-button.btnaccorlink>
                            @endif
                            {{-- <x-button.btn color="red" padding="px-3 py-1">Delete</x-button.btn> --}}
                        </x-table.td>  
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table.table>
        @if($partisipans->hasPages())
            <div class="mt-4 lg:w-3/4">
                {{ $partisipans->links() }}
            </div>
        @endif
    </div>
</div>
