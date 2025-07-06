<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Rooms')" :description="__('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellat, dolorem.')" />
    
   <div class="">
        <x-button.btnaccorlink navigate=true class="mb-4" href="{{ route('room.create') }}">
            {{ __('Add Room') }}
        </x-button.btnaccorlink>

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
                   @foreach($rooms as $room)
                        <x-table.tr>
                            <x-table.td>{{ $loop->iteration }}</x-table.td>
                            <x-table.td>{{ $room->room_code }}</x-table.td>
                            <x-table.td>{{ $room->product->product_name }}</x-table.td>
                            <x-table.td>{{ $room->status }}</x-table.td>
                            <x-table.td>{{ $room->start_time }}</x-table.td>
                            <x-table.td class="flex md:flex-wrap gap-2"> 
                                <x-button.btnaccorlink href="{{ Route('room.edit',$room->room_code) }}" color="blue" padding="px-3 py-1">Detail</x-button.btnaccorlink>
                                <x-button.btnaccorlink href="{{ Route('room.edit',$room->room_code) }}" color="yellow" padding="px-3 py-1">Preview</x-button.btnaccorlink>
                                <x-button.btnaccorlink href="{{ Route('room.edit',$room->room_code) }}" color="green" padding="px-3 py-1">Start</x-button.btnaccorlink>
                                <x-button.btn color="red" padding="px-3 py-1">Delete</x-button.btn>
                            </x-table.td>  
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table.table>
        </div>
    </div>
</div>
