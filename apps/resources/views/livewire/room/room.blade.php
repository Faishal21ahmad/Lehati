<div class="mt-20 text-white">
    {{-- <section class="flex max-w-screen-2xl mx-auto px-4 lg:px-8 py-4 gap-4">
        <div class="w-[70%] flex lg:flex-row flex-col gap-5 ">
            <div id="imageProduk" class="lg:w-2/5 w-full">
                <x-carousel.carousel :fileproduct="$images" wight="h-[300px] md:h-[400px] lg:h-[500px]" />
            </div>
            <div id="detailProduk" class="w-full lg:w-3/5 overflow-hidden">
                <div class="justify-between items-center flex">
                    <h1 class="text-3xl font-semibold py-4">{{ $room->product->product_name }}</h1>
                    <h1>{{ $room->room_code }}</h1>
                </div>
                <hr class="my-2">
                <div id="detail" class="flex gap-2">
                    <div id="title" class="">
                        <p>Kuantitas</p>
                        <p>Harga Awal</p>
                        <p>Tawaran Minimum</p>
                        <p>Waktu Mulai</p>
                        <p>Waktu Selesi</p>
                    </div>
                    <div id="value" class="">
                        <p class="uppercase">: {{ $room->product->quantity }} {{ $room->product->units }}</p>
                        <p class="">: Rp. {{ number_format($room->starting_price, 0, ',', '.') }}</p>
                        <p class="">: Rp. {{ number_format($room->min_bid_step, 0, ',', '.') }}</p>
                        <p class="">: {{ \Carbon\Carbon::parse($room->start_time)->translatedFormat('l, d F Y H:i') }}</p>
                        <p class="">: {{ \Carbon\Carbon::parse($room->end_time)->translatedFormat('l, d F Y H:i') }}</p>
                    </div>
                </div>
                <hr class="my-2">
                <h2>Deskripsi Produk : </h2>
                <p>{{ $room->product->description }}</p>
                <hr class="my-2">
                <h2>Note Room : </h2>
                <p>{{ $room->room_notes }}</p>
                <hr class="my-2">
                <div id="detail" class="flex gap-2">
                    <div id="title" class="">
                        <p>Penyelenggara</p>
                        <p>Alamat</p>
                    </div>
                    <div id="value" class="">
                        <p class="">: {{ $room->user->name }}</p>
                        <p class="">: {{ $room->user->userdata->address }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="jumlahPeserta" class="w-[30%]">
            <div class="w-full p-2 bg-slate-800 rounded-2xl flex justify-between items-center flex-col">
                <p class="text-lg">Peserta</p>
                <hr>
                <p class="">{{ $room->participants->count() }}</p>
                <hr>
                <x-button.btn class="w-full mt-2" color="green" wire:click="joinRoom">Join Room</x-button.btn> 
            </div>
        </div>
    </section> --}}

    <section class="max-w-screen-2xl mx-auto px-4 lg:px-8 py-6 flex flex-col lg:flex-row gap-6">
    {{-- Kiri: Gambar + Detail --}}
    <div class="w-full lg:w-[70%] flex flex-col gap-6">
        {{-- Carousel Produk --}}
        <div class="w-full shadow-md bg-white dark:bg-slate-800 rounded-2xl ">
            <x-carousel.carousel :fileproduct="$images" wight="h-[300px] md:h-[400px] lg:h-[500px]" />
        </div>

        {{-- Detail Produk --}}
        <div class="w-full bg-white dark:bg-slate-800 rounded-xl shadow-md p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                    {{ $room->product->product_name }}
                </h1>
                <span class="text-sm md:text-base font-mono text-black dark:text-white bg-slate-100 dark:bg-slate-700 px-3 py-1 rounded">
                    Kode: {{ $room->room_code }}
                </span>
            </div>
            <hr class="my-4 text-slate-600">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700 dark:text-slate-200">
                
                    <div id="detail" class="flex gap-2">
                        <div id="title" class="font-semibold">
                            <p>Kuantitas</p>
                            <p>Harga Awal</p>
                            <p>Tawaran Minimum</p>
                        </div>
                        <div id="value" class="">
                            <p class="uppercase">: {{ $room->product->quantity }} {{ $room->product->units }}</p>
                            <p class="">: Rp. {{ number_format($room->starting_price, 0, ',', '.') }}</p>
                            <p class="">: Rp. {{ number_format($room->min_bid_step, 0, ',', '.') }}</p>
                        </div>
                    </div>
                <div id="detail" class="flex gap-2">
                        <div id="title" class="font-semibold">
                            <p>Waktu Mulai</p>
                            <p>Waktu Selesi</p>
                        </div>
                        <div id="value" class="">
                            <p class="">: {{ \Carbon\Carbon::parse($room->start_time)->translatedFormat('l, d F Y H:i') }}</p>
                            <p class="">: {{ \Carbon\Carbon::parse($room->end_time)->translatedFormat('l, d F Y H:i') }}</p>
                        </div>
                    </div>
            </div>

            <hr class="my-4 text-slate-600">

            <div class="space-y-2 text-sm text-slate-700 dark:text-slate-200">
                <div>
                    <h2 class="font-semibold text-base">Deskripsi Produk:</h2>
                    <p>{{ $room->product->description }}</p>
                </div>
                <div>
                    <h2 class="font-semibold text-base">Catatan Room:</h2>
                    <p>{{ $room->room_notes ?? '-' }}</p>
                </div>
            </div>

           <hr class="my-4 text-slate-600">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700 dark:text-slate-200">
                <div>
                    <p><span class="font-semibold">Penyelenggara:</span> {{ $room->user->name }}</p>
                    <p><span class="font-semibold">Alamat:</span> {{ $room->user->userdata->address }}</p>
                   
                </div>
            </div>
        </div>
    </div>

    {{-- Kanan: Peserta --}}
    <div class="w-full lg:w-[30%]">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 flex flex-col items-center text-center">
            <p class="text-xl font-semibold text-slate-800 dark:text-white mb-2">Jumlah Peserta</p>
            <p class="text-4xl font-bold text-green-500 mb-4">{{  $room->participants()->where('status', 'joined')->count() }}</p>
            @auth
                @if ($this->isJoined())
                    {{-- Tombol keluar --}}
                    <x-button.btn class="w-full" color="red" wire:click="leaveRoom">
                        Keluar Lelang
                    </x-button.btn>
                @else
                    {{-- Tombol gabung --}}
                    <x-button.btn class="w-full" color="green" wire:click="joinRoom">
                        Gabung Lelang
                    </x-button.btn>
                @endif
            @else
                <x-button.btn class="w-full" color="green" wire:click="joinRoom">
                    Gabung Lelang
                </x-button.btn>
            @endauth
        </div>
    </div>
</section>

</div>
