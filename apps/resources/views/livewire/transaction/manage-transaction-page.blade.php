<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Transactions')" :description="__('Manage all Transaction')" />
    <div class="flex flex-col gap-2">
        <x-input.search id="search"  />
        <x-table.table class="lg:w-3/4">
            <x-table.thead>
                <x-table.th>no</x-table.th>
                <x-table.th>Code Transaction</x-table.th>
                <x-table.th>Status</x-table.th>
                <x-table.th>Code User</x-table.th>
                <x-table.th>Code Room</x-table.th>
                <x-table.th>action</x-table.th>
            </x-table.thead>
            <x-table.tbody>
                @forelse($transactions as $transaction)
                    <x-table.tr>
                        <x-table.td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $transaction->code_transaksi }}</x-table.td>
                        <x-table.td>
                            <span @class(['rounded-full text-white px-3 py-1',
                                'bg-red-700' => in_array($transaction->status, ['unpaid', 'failed']),
                                'bg-yellow-700' => $transaction->status === 'payment-verification',
                                'bg-green-700' => $transaction->status === 'success',
                            ])>
                                {{ Str::title($transaction->status) }}
                            </span>
                        </x-table.td>
                        <x-table.td>{{ $transaction->user->code_user }}</x-table.td>
                        <x-table.td>{{ $transaction->bid->room->room_code }}</x-table.td>
                        <x-table.td class="flex md:flex-wrap gap-2"> 
                            <x-button.btnaccorlink href="{{ Route('transaction.detail', $transaction->code_transaksi) }}" color="blue" padding="px-3 py-1">Pay</x-button.btnaccorlink>
                        </x-table.td>  
                    </x-table.tr>
                @empty
                    <x-table.tr class="w-full">
                        <x-table.td colspan="6" class="text-center py-4">No accounts found</x-table.td>
                    </x-table.tr>
                @endforelse
            </x-table.tbody>
        </x-table.table>
        @if($transactions->hasPages())
            <div class="mt-4 lg:w-3/4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
