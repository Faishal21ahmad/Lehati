<div class="px-6 pt-2 md:p-8 md:ml-64  text-black dark:text-white">
    <x-layouts.app-header
    :title="$roomId ? __('Detail Room') : __('Add Room')"
    {{-- :description="__('Create New Room Auctioneer')"  --}}
    :description="$roomId ? __('Detail Room Product') : __('Create New Room Auctioneer')" 
    
    
    />

    <div class="w-full flex lg:flex-row flex-col-reverse gap-4 mt-4">
        <div class="w-full">
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
                    <x-button.btn type="submit">{{ $roomId ? 'Update' : 'Simpan' }}</x-button.btn>
                    <x-button.btnaccorlink navigate=true type="button" href="{{ Route('room.manage') }}" color="yellow">Back</x-button.btnaccorlink>
                </div>
            </form>
        </div>
        <div class="w-full"></div>
    </div>
</div>