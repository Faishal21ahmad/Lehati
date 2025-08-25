<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app',  ['title' => "Transaction"])]
class ManageTransactionPage extends Component // Halaman Data Semua Transaksi Admin
{
    use WithPagination;
    public $query = '';
    public function render()
    {   // Ambil data Transaksi + query search
        $transactions = Transaction::query()
            ->with(['user', 'bid.room'])
            ->when($this->query, function ($q) {
                $search = $this->query;

                $q->where('code_transaksi', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas(
                        'user',
                        fn($q) =>
                        $q->where('code_user', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'bid.room',
                        fn($q) =>
                        $q->where('room_code', 'like', "%{$search}%")
                    );
            })
            ->latest()
            ->paginate(10);

        return view('livewire.transaction.manage-transaction-page', [
            'transactions' => $transactions
        ]);
    }
}
