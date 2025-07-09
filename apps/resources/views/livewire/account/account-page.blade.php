<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Account')" :description="__('Manage all account user')" />
    
    <div class="flex flex-col gap-2">

        <x-input.search id="search"  />

        <x-table.table class="lg:w-3/4">
            <x-table.thead>
                <x-table.th>no</x-table.th>
                <x-table.th>Code User</x-table.th>
                <x-table.th>Name</x-table.th>
                <x-table.th>Role</x-table.th>
                <x-table.th>status</x-table.th>
                <x-table.th>action</x-table.th>
            </x-table.thead>
            <x-table.tbody>
                @forelse($accounts as $account)
                    <x-table.tr>
                        <x-table.td>{{ ($accounts->currentPage() - 1) * $accounts->perPage() + $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $account->code_user }}</x-table.td>
                        <x-table.td>{{ $account->name }}</x-table.td>
                        <x-table.td>{{ $account->role }}</x-table.td>
                        <x-table.td>
                            @if ($account->is_active)
                                <span class="px-3 py-1 bg-green-500 rounded-full text-white font-semibold">active</span> 
                            @else
                                <span class="px-3 py-1 bg-red-500 rounded-full text-white font-semibold">inactive</span> 
                            @endif
                        </x-table.td>
                        <x-table.td class="flex md:flex-wrap gap-2"> 
                            <x-button.btnaccorlink href="{{ Route('account.edit', $account->code_user) }}" color="blue" padding="px-3 py-1">Detail</x-button.btnaccorlink>
                            
                        
                        </x-table.td>  
                    </x-table.tr>
                @empty
                    <x-table.tr class="w-full">
                        <x-table.td colspan="6" class="text-center py-4">No accounts found</x-table.td>
                    </x-table.tr>
                @endforelse
            </x-table.tbody>
        </x-table.table>
        
        @if($accounts->hasPages())
            <div class="mt-4 lg:w-3/4">
                {{ $accounts->links() }}
            </div>
        @endif
    </div>
</div>