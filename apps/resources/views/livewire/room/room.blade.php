<div class="mt-20 text-white">
    <section class="max-w-screen-2xl mx-auto px-4 lg:px-8 py-4 flex flex-col lg:flex-row gap-4">
        {{-- Kiri: Gambar + Detail --}}
        <div class="w-full lg:w-[70%] flex flex-col gap-4">
            {{-- Carousel Produk --}}
            <div class="w-full shadow-sm bg-white dark:bg-gray-800 rounded-md ">
                <x-carousel.carousel :fileproduct="$images" wight="h-[300px] md:h-[400px] lg:h-[500px]" />
            </div>
            {{-- Detail Produk --}}
            <div class="w-full bg-white dark:bg-gray-800 rounded-md shadow-sm p-4 md:p-6">
                <div class="flex flex-row justify-between items-start md:items-center mb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $room->product->product_name }}
                    </h1>
                    <span class="text-sm md:text-base font-mono text-black dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded">
                        Code: {{ $room->room_code }}
                    </span>
                </div>
                <hr class="my-3 text-gray-600">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-200">
                        <div id="detail" class="flex gap-2">
                            <div id="title" class="font-semibold">
                                <p>Quantity</p>
                                <p>Starting Price</p>
                                <p>Minimum Bid</p>
                            </div>
                            <div id="value" class="">
                                <p class="uppercase">: {{ $room->product->quantity }} {{ $room->product->units }}</p>
                                <p class="">: Rp. {{ number_format($room->starting_price, 0, ',', '.') }}</p>
                                <p class="">: Rp. {{ number_format($room->min_bid_step, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    <div id="detail" class="flex gap-2">
                            <div id="title" class="font-semibold">
                                <p>Starting Time</p>
                                <p>End Time</p>
                            </div>
                            <div id="value" class="">
                                <p class="">: {{ \Carbon\Carbon::parse($room->start_time)->translatedFormat('l, d F Y H:i') }}</p>
                                <p class="">: {{ \Carbon\Carbon::parse($room->end_time)->translatedFormat('l, d F Y H:i') }}</p>
                            </div>
                        </div>
                </div>
                <hr class="my-3 text-gray-600">
                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-200">
                    <div>
                        <h2 class="font-semibold text-base">Product Description :</h2>
                        <p>{{ $room->product->description }}</p>
                    </div>
                    <div>
                        <h2 class="font-semibold text-base">Room Notes :</h2>
                        <p>{{ $room->room_notes ?? '-' }}</p>
                    </div>
                </div>
                <hr class="my-3 text-gray-600">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-200">
                    <div>
                        <p><span class="font-semibold">Auction Organizer :</span> {{ $room->user->name }}</p>
                        <p><span class="font-semibold">Address :</span> {{ $room->user->userdata->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Peserta --}}
        <div class="w-full lg:w-[30%] flex flex-col gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm p-3 md:p-4 gap-2 flex flex-col items-center text-center">
                <p class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Jumlah Peserta</p>
                <p class="text-4xl font-bold text-green-500 mb-4">{{  $room->participants()->where('status', 'joined')->count() }}</p>
                
                @if ($room->status == "cancelled")
                    <p class="w-full bg-red-600 rounded-md py-2 shadow-sm">Room Cancelled</p>
                @elseif($room->status =="ended")
                    <p class="w-full bg-gray-600 rounded-md py-2 shadow-sm">Room Ended</p>
                @else
                    @can('bidder')
                        @auth
                            @if ($this->isJoined())
                            {{-- Tombol keluar --}}
                            <x-button.btn class="w-full" color="red" wire:click="leaveRoom">
                                Cancel Join
                            </x-button.btn>
                            <x-button.btn class="w-full" color="green" wire:click="startbidding">
                                Start Bidding
                            </x-button.btn>
                            @else
                            {{-- Tombol gabung --}}
                            <x-button.btn class="w-full" color="green" wire:click="joinRoom">
                                Join Room
                            </x-button.btn>
                            @endif
                        @else
                        <x-button.btn class="w-full" color="green" wire:click="joinRoom">
                            Join Room
                        </x-button.btn>
                        @endauth
                    @endcan
                @endif
            </div>
            @if($room->status =="ended")
            <div class="bg-white dark:bg-gray-800 text-black dark:text-white rounded-md shadow-sm">
                <h1 class="p-4 w-full text-center font-semibold">Winner</h1>
                <div class="px-4 pb-4 flex w-full gap-2 ">
                    <div class="">
                        <p>Highest Bid</p>
                        <p>Code User</p>
                        <p>Name User</p>
                        @if( $user->code_user == $transaksiWinner->participant->user->code_user || $transaksiWinner )
                            <p>ID Transaction</p>
                        @endif
                    </div>
                    <div class="">
                        <p>: Rp. {{ number_format($transaksiWinner->amount, 0, ',', '.') }}</p>
                        <p>: {{ $transaksiWinner->participant->user->code_user }}</p>
                        <p>: {{ $transaksiWinner->participant->user->name }}</p>
                        @if( $user->code_user == $transaksiWinner->participant->user->code_user )
                            <p class="">: <x-button.accorlink class="font-semibold" href="{{ Route('transaction.detail', $transaksiWinner->transaction->code_transaksi) }}">{{ $transaksiWinner->transaction->code_transaksi }}</x-button.accorlink></p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
