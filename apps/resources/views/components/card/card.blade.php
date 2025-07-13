@props([
    'data' => []
    ])

<a href="{{ Route('room.detail', $data->room_code) }}"  >
    <div class="
    max-w-44
    min-w-40
    {{-- max-w-52 --}}
    max-h-64 bg-white border border-gray-200 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-700  mx-auto">
        <div class="h-32 overflow-hidden flex justify-center items-center rounded-t-md">
            <img  src="{{ asset('storage/'.$data->product->images[0]->image_path ) }}" alt="" />
        </div>
        
        <div class="p-2.5 overflow ">
            <h5 class="mb-1 text-xl font-semibold tracking-tight text-gray-900 dark:text-white whitespace-nowrap truncate">{{ $data->product->product_name }}</h5>
            <p class="mb-1 font-normal text-sm text-gray-700 dark:text-gray-400">Rp. {{ number_format($data->starting_price, 0, ',', '.') }}</p>
            <p class="mb-1 font-normal text-sm text-gray-700 dark:text-gray-400 truncate">{{ $data->product->quantity }} {{ $data->product->units }}</p>
            {{-- <p class="mb-3 font-normal text-sm text-gray-700 dark:text-gray-400 truncate">{{ $data->start_time }}</p> --}}
            <p class="mb-1 font-normal text-sm text-gray-700 dark:text-gray-400 truncate">{{ \Carbon\Carbon::parse($data->start_time)->translatedFormat('l, d F Y H:i') }}</p>
        </div>
    </div>
</a>