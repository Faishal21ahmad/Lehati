<div class="px-6 pt-2 md:p-8 md:ml-64  text-black dark:text-white">
    <x-layouts.app-header
    :title="$roomId ? __('Detail Room') : __('Add Room')"
    :description="$roomId ? __('Detail Room Product') : __('Create New Room Auctioneer')" 
    />

    <div class="w-full flex lg:flex-row flex-col gap-4 mt-4">
        <div class="w-full flex flex-col gap-5">
            <form wire:submit.prevent="save" enctype="multipart/form-data">
                @if ($roomId)
                    <x-input.input type="text" id="coderoom" label="Room Code" disabled/>
                    <x-input.select id="product" label="Product" placeholder="Pilih Product" :options="$products" disabled error="{{ $errors->first('product') }}" />
                    <x-input.input type="text" id="status" label="Status" disabled/>
                @endif
                @if (!$roomId)
                    <x-input.select id="product" label="Select Product" placeholder="Pilih Product" :options="$products" error="{{ $errors->first('product') }}" />
                @endif
                <x-input.input type="number" id="starting_price" label="Starting Price" placeholder="Rp 100.000" required error="{{ $errors->first('starting_price') }}"/>
                <x-input.input type="number" id="min_bid_step" label="Minimum Bid" placeholder="Rp 20.000" required error="{{ $errors->first('min_bid_step') }}"/>
                <div class="flex gap-4">
                    <x-input.datepicker id="start_time" label="Start Time" error="{{ $errors->first('start_time') }}" value="{{ old('start_time', $start_time) }}"/>
                    <x-input.datepicker id="end_time" label="End Time" error="{{ $errors->first('end_time') }}" value="{{ old('end_time', $end_time) }}"/>
                </div>
                <x-input.textarea id="room_notes" label="Room Notes" placeholder="" error="{{ $errors->first('room_notes') }}"/>
                <div class="mt-2">
                    <x-button.btnaccorlink navigate=true type="button" href="{{ Route('rooms') }}" color="yellow">Back</x-button.btnaccorlink>
                    <x-button.btn type="submit">{{ $roomId ? 'Update' : 'Simpan' }}</x-button.btn>
                    @if ($roomId && $status != "ended" && $status != "cancelled")
                        <x-button.btn wire:click="startbidding" color="green">Start Room</x-button.btn>    
                        <x-button.btn wire:click="cancelRoom" color="yellow">Cencel Room</x-button.btn>    
                    @endif
                </div>
            </form>
            <hr>
        </div>
        <div class="w-full flex flex-col gap-3">
            @if($status =="ended")
            <section class="">
                <h1 class="font-semibold px-3 py-1">Winner</h1>
                <div class="flex w-full gap-2 p-4 bg-white dark:bg-gray-800 rounded-md shadow-sm">
                    <div class="">
                        <p>Highest Bid</p>
                        <p>Code User</p>
                        <p>Name User</p>
                        <p>ID Transaction</p>
                    </div>
                    <div class="">
                        <p>: Rp. {{ number_format($transaksiWinner->amount ?? 0, 0, ',', '.') }}</p>
                        <p>: {{ $transaksiWinner->participant->user->code_user ?? '' }}</p>
                        <p>: {{ $transaksiWinner->participant->user->name ?? '' }}</p>
                        <p class="">: 
                            @if ($transaksiWinner)
                                <x-button.accorlink class="font-semibold" href="{{ Route('transaction.detail', $transaksiWinner->transaction->code_transaksi) }}">{{ $transaksiWinner->transaction->code_transaksi }}</x-button.accorlink>
                            @endif
                        </p>
                    </div>
                </div>
            </section>
            @endif
            @if ($roomId)
            <section id="cardInformation" class="w-full flex flex-col gap-2">
                <h1 class="font-semibold px-3 py-1">Participants</h1>
                <div class="flex gap-2 w-full">
                    <div class="w-full p-2 text-center rounded-md shadow-sm bg-white dark:bg-gray-800">
                        <h1 class="font-semibold text-lg">Join</h1>
                        <p>{{ $countpartisipantjoin }}</p>
                    </div>
                    <div class="w-full p-2 text-center rounded-md shadow-sm bg-white dark:bg-gray-800">
                        <h1 class="font-semibold text-lg">Leave</h1>
                        <p>{{ $countpartisipantleave }}</p>
                    </div>
                    <div class="w-full p-2 text-center rounded-md shadow-sm bg-white dark:bg-gray-800">
                        <h1 class="font-semibold text-lg">Rejected</h1>
                        <p>{{ $countpartisipantrejected }}</p>
                    </div>
                </div>
            </section>

            <section id="detailPartisipan" class="mt-2 w-full">
                <x-table.table class="w-full">
                    <x-table.thead>
                        <x-table.th>No</x-table.th>
                        <x-table.th>Code User</x-table.th>
                        <x-table.th>Username</x-table.th>
                        <x-table.th>Status</x-table.th>
                        <x-table.th>action</x-table.th>
                    </x-table.thead>
                    <x-table.tbody>
                        @forelse($partisipantjoin as $partisipant)
                            <x-table.tr>
                                <x-table.td>{{ $loop->iteration }}</x-table.td>
                                <x-table.td>{{ $partisipant->user->code_user }}</x-table.td>
                                <x-table.td>{{ $partisipant->user->name }}</x-table.td>
                                <x-table.td>{{ $partisipant->status }}</x-table.td>
                                <x-table.td class="flex md:flex-wrap gap-2"> 
                                    <x-button.btn wire:click="rejectpartisipan({{ $partisipant->user->id }})" color="red" padding="px-3 py-1">Reject</x-button.btn>
                                </x-table.td>  
                            </x-table.tr>
                        @empty
                            <x-table.tr class="w-full">
                                <x-table.td colspan="6" class="text-center py-4">No Room found</x-table.td>
                            </x-table.tr>
                        @endforelse
                    </x-table.tbody>
                </x-table.table>
            </section>
            @endif
        </div>
    </div>
</div>
