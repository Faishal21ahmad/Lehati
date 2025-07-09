@props([
    'data' => []
    ])

<a href="{{ Route('room.detail', $data->room_code) }}"  >
    <div class="w-52 h-72 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="h-36 overflow-hidden flex justify-center items-center rounded-t-lg">
            <img  src="{{ asset('storage/'.$data->product->images[0]->image_path ) }}" alt="" />
        </div>
        
        <div class="p-3 overflow ">
            <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white whitespace-nowrap truncate">{{ $data->product->product_name }}</h5>
            <p class="mb-2 font-normal text-sm text-gray-700 dark:text-gray-400">Starting ... Rp. {{ number_format($data->starting_price, 0, ',', '.') }}</p>
            <p class="mb-2 font-normal text-sm text-gray-700 dark:text-gray-400 truncate">{{ $data->product->quantity }} {{ $data->product->units }}</p>
            {{-- <p class="mb-3 font-normal text-sm text-gray-700 dark:text-gray-400 truncate">{{ $data->start_time }}</p> --}}
            <p class="mb-2 font-normal text-sm text-gray-700 dark:text-gray-400 truncate">{{ \Carbon\Carbon::parse($data->start_time)->translatedFormat('l, d F Y H:i') }}</p>
        </div>
    </div>
</a>