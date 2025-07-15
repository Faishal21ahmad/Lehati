<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Rooms')" :description="__('Manage all room')" />
    
    <div class="">
        <div class="flex gap-2 items-center mb-2">
            <x-button.btnaccorlink navigate=true  href="{{ route('room.create') }}">
                {{ __('Add Room') }}
            </x-button.btnaccorlink>
            <x-input.search id="search" class="w-3/5" />
        </div>
        <div class="">
            <x-table.table class="lg:w-3/4">
                <x-table.thead>
                    <x-table.th>No</x-table.th>
                    <x-table.th>Code Room</x-table.th>
                    <x-table.th>Product</x-table.th>
                    <x-table.th>status</x-table.th>
                    <x-table.th>Start Time</x-table.th>
                    <x-table.th>action</x-table.th>
                </x-table.thead>
                <x-table.tbody>
                   @forelse($rooms as $room)
                        <x-table.tr>
                            <x-table.td>{{ ($rooms->currentPage() - 1) * $rooms->perPage() + $loop->iteration }}</x-table.td>
                            <x-table.td>{{ $room->room_code }}</x-table.td>
                            <x-table.td>{{ $room->product->product_name }}</x-table.td>
                            <x-table.td>
                                <span @class(['rounded-full text-white px-3 py-1',
                                'bg-red-700' => $room->status === 'cancelled',
                                'bg-yellow-700' => $room->status === 'upcoming',
                                'bg-green-700' => $room->status === 'ongoing',
                                'bg-gray-700' => $room->status === 'ended',
                                ])>
                                    {{ Str::title($room->status) }}
                                </span>
                            </x-table.td>
                            <x-table.td>{{ $room->start_time }}</x-table.td>
                            <x-table.td class="flex md:flex-wrap gap-2"> 
                                <x-button.btnaccorlink href="{{ Route('room.edit',$room->room_code) }}" color="blue" padding="px-3 py-1">Detail</x-button.btnaccorlink>
                                <x-button.btnaccorlink href="{{ Route('room.detail', $room->room_code) }}" color="yellow" padding="px-3 py-1">Preview</x-button.btnaccorlink>
                                <x-button.btn wire:click="confirmDelete({{ $room->id }})" color="red" padding="px-3 py-1">Delete</x-button.btn>
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr class="w-full">
                            <x-table.td colspan="6" class="text-center py-4">No Room found</x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-table.tbody>
            </x-table.table>
            <div class="mt-4">
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
    @if($showModal)
    <!-- Modal Konfirmasi Delete -->
    <x-modal.modal-confrim
        message="Are you sure you want to delete this Room {{ $roomcode }} ?"
        confirmMethod="delete"
    />
    @endif
</div>
