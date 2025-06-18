<div class="">
    <div class="max-w-screen-2xl mx-auto mt-20">
    {{-- <div class="mt-26 items-center mx-auto justify-center max-w-screen-2xl grid grid-cols-5 grid-rows-4 gap-4 "> --}}

    <h1 class="text-xl dark:text-white py-4 pl-7">Up Coming</h1>
    <section class="w-full flex flex-nowrap overflow-auto overflow-x-visible gap-4 mx-auto p-4">
        @foreach ($roomupcoming as $item)
            <x-card.card :data="$item" />
            <x-card.card :data="$item" />
        @endforeach
    </section>

    <h1 class="text-xl dark:text-white py-4 pl-7">All Product</h1>
    <section class="w-full flex flex-wrap items-center justify-center gap-4 mx-auto p-4 ">
        @foreach ($room as $item)
            <x-card.card :data="$item" />
            <x-card.card :data="$item" />
        @endforeach
    </section>
        
    </div>
</div>
