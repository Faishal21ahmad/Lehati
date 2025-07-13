
    <div class="max-w-screen-2xl mx-auto mt-20">
        <x-input.search id="search" class="w-[90%] mx-auto" />
        {{-- hanya tampil saat TIDAK melakukan pencarian --}}
        @if(empty($query))
            @if($ongoing->isNotEmpty())
                <h1 class="text-xl dark:text-white py-4 pl-7">On Going</h1>
                <section class="w-full flex flex-nowrap overflow-auto overflow-x-visible gap-4 mx-auto p-4 scrollbar-hide ">
                    @foreach ($ongoing as $item)
                        <x-card.card :data="$item" />
                    @endforeach
                </section>
            @endif

            @if ($roomupcoming->isNotEmpty())
                <h1 class="text-xl dark:text-white py-4 pl-7">Up Coming</h1>
                <section class="w-full flex flex-nowrap overflow-auto overflow-x-visible gap-4 mx-auto p-4 scrollbar-hide">
                    @foreach ($roomupcoming as $item)
                        <x-card.card :data="$item" />
                    @endforeach
                </section>
            @endif
        @endif

        {{-- bagian pencarian & all product --}}
        @if($rooms->isNotEmpty())
            <h1 class="text-xl dark:text-white py-4 pl-7">
                {{ empty($query) ? 'All Product' : 'Search Result' }}
            </h1>
            <section class="w-full flex flex-wrap justify-center sm:justify-start items-center gap-4 mx-auto p-4 ">
                @foreach($rooms as $item)
                    <x-card.card :data="$item" />
                @endforeach
            </section>
        @elseif(!empty($query))
            <p class="text-center text-gray-400 dark:text-gray-500 py-8">Tidak ada hasil untuk "{{ $query }}"</p>
        @endif
    </div>
