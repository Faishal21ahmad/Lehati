<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Dashboard')" :description="__('Detail Information data')" />
    
    @can('admin')
    <div class="flex flex-col gap-4">
        <section id="Transaction" class="flex flex-col gap-4">
            <h1 class="text-xl font-bold">Transaction</h1>
            <div class="flex w-full flex-col lg:flex-row gap-4">
                <x-card.cardinfo label="Transaction Unpaid" value="{{ $transactionUnpaid }}" />
                <x-card.cardinfo label="Transaction Proses" value="{{ $transactionProses }}" />
                <x-card.cardinfo label="Transaction Failed" value="{{ $transactionFailed }}" />
                <x-card.cardinfo label="Transaction Success" value="{{ $transactionSuccess }}" />
            </div>
        </section>
        
        <section id="Room" class="flex flex-col gap-4">
            <h1 class="text-xl font-bold">Room</h1>
            <div class="flex w-full flex-col lg:flex-row gap-4">
                <x-card.cardinfo label="Room Available" value="{{ $roomUpComing }}" />
                <x-card.cardinfo label="Room Sold" value="{{ $roomOnGoing }}" />
                <x-card.cardinfo label="Room Use" value="{{ $roomEnded }}" />
                <x-card.cardinfo label="Room Use" value="{{ $roomCancelled }}" />
            </div>
        </section>
        
        <section id="user" class="flex flex-col gap-4">
            <h1 class="text-xl font-bold">Account</h1>
            <div class="flex w-full flex-col sm:flex-row gap-4">
                <x-card.cardinfo label="Account Active" value="{{ $accountActive }}" />
                <x-card.cardinfo label="Account Active" value="{{ $accountInActive }}" />
            </div>
        </section>

        <section id="Product" class="flex flex-col gap-4">
            <h1 class="text-xl font-bold">Product</h1>
            <div class="flex w-full flex-col md:flex-row gap-4">
                <x-card.cardinfo label="Product Available" value="{{ $productAvailable }}" />
                <x-card.cardinfo label="Product Sold" value="{{ $productSold }}" />
                <x-card.cardinfo label="Product Use" value="{{ $productUse }}" />
            </div>
        </section>

        {{-- <section id="" class="flex flex-col gap-4">
            <h1 class="text-xl font-bold"></h1>
            <div class="flex w-full gap-4">
            </div>
        </section> --}}
    </div>
    @endcan
        
    @can('bidder')
    <div class="flex flex-col gap-4">
        <section id="Transaction" class="flex flex-col gap-4">
            <h1 class="text-xl font-bold">Transaction</h1>
            <div class="flex w-full flex-col lg:flex-row gap-4">
                <x-card.cardinfo label="Transaction Unpaid" value="{{ $transactionUnpaid }}" />
                <x-card.cardinfo label="Transaction Proses" value="{{ $transactionProses }}" />
                <x-card.cardinfo label="Transaction Failed" value="{{ $transactionFailed }}" />
                <x-card.cardinfo label="Transaction Success" value="{{ $transactionSuccess }}" />
            </div>
        </section>
        <section id="" class="flex flex-col gap-4">
            <h1 class="text-xl font-bold">Room Partisipan</h1>
            <div class="flex w-full gap-4">
                <x-card.cardinfo label="Join Room" value="{{ $roomPartisipanJoin }}" />
                <x-card.cardinfo label="Reject for Room" value="{{ $roomPartisipanReject }}" />
                <x-card.cardinfo label="Leave Room" value="{{ $roomPartisipanLeave }}" />
            </div>
        </section>
    </div>
    @endcan
</div>
