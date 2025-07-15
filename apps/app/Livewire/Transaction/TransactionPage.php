<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

#[Layout('components.layouts.app',  ['title' => "Transaction"])]
class TransactionPage extends Component
{
    use WithPagination;
    public $query = '';
    public function updatingQuery()
    {
        $this->resetPage(); // agar halaman balik ke page 1 saat cari
    }

    public function render()
    {   // Ambil data Transaksi + query search
        $user = Auth::user();

        $transactions = Transaction::with(['bid.room.product'])
            ->where('user_id', $user->id)
            ->when($this->query, function ($q) {
                $search = $this->query;

                $q->where(function ($query) use ($search) {
                    $query->where('code_transaksi', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas(
                            'bid.room',
                            fn($q) =>
                            $q->where('room_code', 'like', "%{$search}%")
                        )
                        ->orWhereHas(
                            'bid.room.product',
                            fn($q) =>
                            $q->where('product_name', 'like', "%{$search}%")
                        );
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.transaction.transaction-page', [
            'transactions' => $transactions
        ]);
    }
}
