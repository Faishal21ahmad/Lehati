<div class="max-w-screen-2xl p-4 mx-auto mt-20 text-white">
    
    <section class="flex flex-col md:flex-row w-full gap-4" >
        <div id="images" class="md:w-[30%] w-full flex flex-col gap-4">
            <div class="w-full shadow-md bg-white dark:bg-slate-800 rounded-lg ">
                <x-carousel.carousel :fileproduct="$images" wight="h-[300px] md:h-[200px] lg:h-[300px]" />
            </div>
            <div class="p-4 dark:bg-slate-800 rounded-lg flex gap-2">
                <div class="">
                    <p>Room Code</p>
                    <p>Name Product</p>
                    <p>Quantity</p>
                    <p>Starting Price</p>
                    <p>Minimum Bid</p>
                </div>
                <div class="">
                    <p>: {{ $room->room_code }}</p>
                    <p>: {{ $room->product->product_name }}</p>
                    <p>: {{ $room->product->quantity }} {{ $room->product->units }}</p>
                    <p>: Rp. {{ number_format($room->starting_price , 0, ',', '.') }}</p>
                    <p>: Rp. {{ number_format($room->min_bid_step , 0, ',', '.') }}</p>
                </div>
            </div>
            @can('admin')
            <div class="">
                <x-button.btn class="w-full" color="red" wire:click="endRoom">
                    Stop Aucctioneer
                </x-button.btn>
            </div>
            @endcan
        </div>
        <div id="bid" class="w-full md:w-[70%] flex flex-col gap-4">
            <div id="topbid" class="p-4 dark:bg-slate-800 rounded-lg ">
                <div class="w-full h-[100px] flex flex-col items-center justify-center ">
                    <h1 class="text-3xl font-bold">Rp. {{ number_format($topBid->amount , 0, ',', '.') }}</h1>
                    <span class="">Top Bid</span>
                </div>
                <div class="w-full h-[50px] flex flex-row gap-4 text-xl font-semibold items-center justify-center ">
                    <p>{{ $topBid->participant->user->name }}</p>
                    <p>{{ $topBid->participant->user->code_user }}</p>
                </div>
            </div>
            @can('bidder')
                <div id="allbid" class="p-4 dark:bg-slate-800 rounded-lg">
                    <form wire:submit="saveNewBid">
                        <x-input.input type="number" id="bidnew" label="Bid" placeholder="10000" error="{{ $errors->first('password') }}"/>
                        <x-button.btn type="submit" class="w-full">Submit</x-button.btn>
                    </form>
                </div>
            @endcan

            <x-table.table class="w-full">
                <x-table.thead>
                    <x-table.th>no</x-table.th>
                    {{-- <x-table.th>id</x-table.th> --}}
                    <x-table.th>Code User</x-table.th>
                    <x-table.th>Amount</x-table.th>
                </x-table.thead>
                <x-table.tbody>
                    @forelse($bids as $bid)
                        <x-table.tr>
                            <x-table.td>{{ $loop->iteration }}</x-table.td>
                            {{-- <x-table.th>{{ $bid->id }}</x-table.th> --}}
                            <x-table.td>{{ $bid->participant->user->code_user }}</x-table.td>
                            <x-table.td>Rp. {{ number_format($bid->amount, 0, ',', '.') }}</x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr class="w-full">
                            <x-table.td colspan="3" class="text-center py-4">No bid found</x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-table.tbody>
            </x-table.table>
        </div>
    </section>
</div>
