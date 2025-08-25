<div class="max-w-screen-2xl p-4 mx-auto mt-20 dark:text-white">
    <section class="flex flex-col md:flex-row w-full gap-4" >
        <div id="images" class="md:w-[30%] w-full flex flex-col gap-4">
            <div class="w-full shadow-sm bg-white dark:bg-gray-800 rounded-lg ">
                <x-carousel.carousel :fileproduct="$images" wight="h-[300px] md:h-[200px] lg:h-[300px]" />
            </div>
             {{-- Informasi Room --}}
            <div id="informasi-room" class="p-4 flex gap-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
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
            {{-- Button EndRoom  --}}
            @can('admin')
            <div class="">
                <x-button.btn class="w-full" color="red" wire:click="endRoom">
                    Stop Aucctioneer
                </x-button.btn>
            </div>
            @endcan
        </div>
        <div id="bid" class="w-full md:w-[70%] flex flex-col gap-4">
            {{-- Informasi TopBid / Bid Tertinggi --}}
            <div id="topbid" class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                {{-- autorefresh data bid 7 detik --}}
                <div wire:poll.7s="refreshbid" class="absolute">
                    <x-button.btn wire:click="refreshbid" color="none" class="w-[55px] h-[55px]">
                        <x-dynamic-component 
                        :component="'icon.' . 'refresh'" class="text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    </x-button.btn>
                </div>

                <div class="w-full h-[100px] flex flex-col items-center justify-center ">
                    <h1 class="text-3xl font-bold">Rp. {{ number_format($bidmount ?? 0 , 0, ',', '.') }}</h1>
                    <span class="">Top Bid</span>
                </div>
                <div class="w-full h-[50px] flex flex-row gap-4 text-xl font-semibold items-center justify-center ">
                    <p>{{ $topBid->participant->user->name ?? 'user' }}</p>
                    <p>{{ $topBid->participant->user->code_user ?? '-----' }}</p>
                </div>
            </div>

            {{-- Form Bid Submit --}}
            @can('bidder')
                <div id="form-bid" class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <form wire:submit="submitNewBid">
                        <x-input.input type="number" id="bidnew" label="Bid" placeholder="10000" error="{{ $errors->first('bidnew') }}"/>
                        <x-button.btn type="submit" class="w-full">Submit</x-button.btn>
                    </form>
                </div>
            @endcan

            {{-- Tabel Informasi Bid history --}}
            <x-table.table id="infobidlog" class="w-full">
                <x-table.thead>
                    <x-table.th>no</x-table.th>
                    <x-table.th>Code User</x-table.th>
                    <x-table.th>Amount</x-table.th>
                </x-table.thead>
                <x-table.tbody>
                    @forelse($bids as $bid)
                        <x-table.tr wire:key="bid-row-{{ $bid->id }}">
                            <x-table.td>{{ $loop->iteration }}</x-table.td>
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
  @push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('refresh-bids', () => {
            // Memaksa refresh komponen jika diperlukan
            Livewire.dispatch('refresh');
        });
    });
</script>
@endpush
</div>

