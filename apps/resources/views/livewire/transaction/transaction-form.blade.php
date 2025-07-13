<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white flex flex-col gap-4">
    <x-layouts.app-header :title="__('Transactions')" :description="__('Manage all Transaction')" />
    <section
        @class(['w-full p-3 font-semibold rounded-md shadow-sm uppercase',
        'bg-red-400 text-black' =>in_array($transaksi->status, ['unpaid', 'failed']),
        'bg-yellow-400 text-black' => $transaksi->status === 'payment-verification',
        'bg-green-400 text-black' => $transaksi->status === 'success',
        ])>
        {{ $transaksi->status }}
    </section>
    <section class="flex flex-col lg:flex-row w-full gap-4">
        <div class="w-full  p-4">
            <h1 class="text-center">Invoice Lelang</h1>
            <hr class="my-2 text-gray-400">
            <div class="flex gap-4">
                <div class="">
                    <p>Code Transaksi</p>
                    <p>Code Room</p>
                    <p>Product</p>
                    <p>Quantity</p>
                    <p>Price</p>
                    <p>Status</p>
                    <p>Note Transaction</p>
                </div>
                <div class="">
                    <p>: {{ $transaksi->code_transaksi }}</p>
                    <p>: {{ $transaksi->bid->room->room_code }}</p>
                    <p>: {{ $transaksi->bid->room->product->product_name }}</p>
                    <p>: {{ $transaksi->bid->room->product->quantity }} {{ $transaksi->bid->room->product->units }}</p>
                    <p>: Rp. {{ number_format($transaksi->bid->amount , 0, ',', '.') }}</p>
                    <p>: <span
                        @class(['px-2 py-0.5 rounded-md shadow-sm text-sm font-semibold',
                            'bg-red-400 text-black' =>in_array($transaksi->status, ['unpaid', 'failed']),
                            'bg-yellow-400 text-black' => $transaksi->status === 'payment-verification',
                            'bg-green-400 text-black' => $transaksi->status === 'success',
                            ])>{{ Str::title($transaksi->status) }}</span></p>
                    <p>: {{ $transaksi->notes ?? ''}}</p>
                </div>
            </div>
            <hr class="my-2 text-gray-400">
            <div class="flex gap-4">
                <div class="">
                    <p>Auctioner</p>
                    <p>Contact</p>
                    <p>Bank</p>
                    <p>Bank Name</p>
                    <p>Number Bank</p>
                </div>
                <div class="">
                    <p>: {{ $transaksi->bid->room->user->name }}</p>
                    <p>: {{ $transaksi->bid->room->user->userdata->phone }}</p>
                    <p>: {{ $transaksi->bid->room->user->userdata->bank }}</p>
                    <p>: {{ $transaksi->bid->room->user->userdata->bank_name }}</p>
                    <p>: {{ $transaksi->bid->room->user->userdata->bank_number }}</p>
                </div>
            </div>
            <hr class="my-2 text-gray-400">
            <div class="flex gap-4">
                <div class="">
                    <p>Bidder</p>
                    <p>Contact</p>
                    <p>Address</p>
                </div>
                <div class="">
                    <p>: {{ $transaksi->bid->participant->user->name }}</p>
                    <p>: {{ $transaksi->bid->participant->user->userdata->phone }}</p>
                    <p>: {{ $transaksi->bid->participant->user->userdata->address }}</p>
                </div>
            </div>
        </div>
        <div class="p-4 w-full ">
            @if($imagepayprof)
                <h1 class="text-center">Proof of Payment</h1>
                <a href="{{ asset('storage/' . $imagepayprof) }}" target="_blank" rel="noopener noreferrer">
                    <div class="group relative h-96 mb-2 overflow-hidden rounded-sm mt-2 cursor-pointer">
                        <img src="{{ asset('storage/' . $imagepayprof) }}" class="rounded shadow w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gray-800 bg-opacity-60 opacity-0 group-hover:opacity-50 transition-opacity duration-200 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Click</span>
                        </div>
                    </div>
                </a>
            @endif

            @can('bidder')
                @if(!$imagepayprof)
                <form wire:submit.prevent="paymenproof">
                    <x-input.file id="filepayment" label="Upload Proof of Payment" helpText="Upload image (jpeg, png, jpg)" error="{{ $errors->first('filepayment.*') }}" />
                        {{-- Preview gambar baru --}}
                        @if ($filepayment)
                            <div class="flex gap-2 mb-2 flex-wrap">
                                <img src="{{ $filepayment->temporaryUrl() }}" class="w-20 h-20 object-cover rounded shadow" />
                            </div>
                        @endif    
                    <x-button.btn type="submit">Submit</x-button.btn>
                </form>
                @endif
            @endcan

            @can('admin')
            @if($transaksi->status == 'payment-verification')
            <h1 class="text-center">Payment Verification</h1>
            <form wire:submit.prevent="paymenVerification">
                <x-input.radio-group title="Status Payment" name="status"
                :options="[
                    ['value' => 'approve', 'label' => 'Approve'],
                    ['value' => 'reject', 'label' => 'Reject']
                ]"
                wire:model="status"
                required="true"
                error="{{ $errors->first('status') }}"
            />
            <x-input.textarea id="notes" label="Notes Payment" error="{{ $errors->first('notes') }}"/> 
            
            <x-button.btn type="submit">Submit</x-button.btn>
            </form>
            @endif
            @endcan
        </div>
    </section>
    {{-- <section class="flex flex-col lg:flex-row w-full gap-4">
        <div class="w-full  p-4">
           
        </div>
        <div class="w-full  p-4">Page</div>
    </section> --}}
</div>
