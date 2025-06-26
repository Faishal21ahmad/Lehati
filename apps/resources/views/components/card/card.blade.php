@props([
    'data' => []
    ])

<a href="{{ Route('room.detail', $data->room_code) }}"  >
    <div class="w-59 h-80 bg-slate-50 border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <img class="rounded-t-lg" src="{{ asset('storage/'.$data->product->images[0]->image_path ) }}" alt="" />
        <div class="p-4 overflow ">
            <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white whitespace-nowrap truncate">{{ $data->product->product_name }}</h5>
            <p class="mb-3 font-normal text-sm text-gray-700 dark:text-gray-400">Starting ... Rp. {{ $data->starting_price }}</p>
            <p class="mb-3 font-normal text-sm text-gray-700 dark:text-gray-400 truncate">{{ $data->product->quantity }} {{ $data->product->units }}</p>
            <p class="mb-3 font-normal text-sm text-gray-700 dark:text-gray-400 truncate">{{ $data->start_time }}</p>
            
        </div>
    </div>
</a>