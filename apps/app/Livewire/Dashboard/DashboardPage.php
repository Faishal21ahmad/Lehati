<?php

namespace App\Livewire\Dashboard;

use App\Models\Participant;
use App\Models\Product;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Dashboard"])]
class DashboardPage extends Component
{
    // Admin
    // Count Account ( Active, Disable )
    // Count Product (Available, Use, Sold)
    // Count Room (Upcoming, Ongoing, Ended, Cancelled)
    // Count Transaksi (Unpaid, Proses, Failed, Success)

    // Bidder
    // Count Partisipan Join Room
    // Count Transaksi Bidder (Unpaid, Proses, Failed, Success)

    // public $user;
    public $accounts, $accountActive, $accountInActive;
    public $products, $productAvailable, $productUse, $productSold;
    public $rooms, $roomUpComing, $roomOnGoing, $roomEnded, $roomCancelled;
    public $transactions, $transactionUnpaid, $transactionProses, $transactionFailed, $transactionSuccess;
    public $roomPartisipan, $roomPartisipanJoin, $roomPartisipanReject, $roomPartisipanLeave;

    public function mount()
    {
        $user = Auth::user();
        if ($user->role->value === 'admin') {
            $this->accounts = User::get();
            $this->accountActive = $this->accounts->where('is_active', true)->count();
            $this->accountInActive = $this->accounts->where('is_active', false)->count();

            // Ambil semua produk & hitung berdasarkan status
            $this->products = Product::get();
            $this->productAvailable = $this->products->where('status', 'available')->count();
            $this->productUse = $this->products->where('status', 'use')->count();
            $this->productSold = $this->products->where('status', 'sold')->count();

            // Ambil semua room
            $this->rooms = Room::get();
            $this->roomUpComing = $this->rooms->where('status', 'upcoming')->count();
            $this->roomOnGoing = $this->rooms->where('status', 'ongoing')->count();
            $this->roomEnded = $this->rooms->where('status', 'ended')->count();
            $this->roomCancelled = $this->rooms->where('status', 'cancelled')->count();

            // Ambil Transaksi 
            $this->transactions = Transaction::get();
            $this->transactionUnpaid = $this->transactions->where('status', 'unpaid')->count();
            $this->transactionProses = $this->transactions->where('status', 'payment-verification')->count();
            $this->transactionFailed = $this->transactions->where('status', 'failed')->count();
            $this->transactionSuccess = $this->transactions->where('status', 'success')->count();
        } else {
            // Ambil data partisipan
            $this->roomPartisipan = Participant::where('user_id', $user->id)->get();
            $this->roomPartisipanJoin = $this->roomPartisipan->where('status', 'joined')->count();
            $this->roomPartisipanReject = $this->roomPartisipan->where('status', 'rejected')->count();
            $this->roomPartisipanLeave = $this->roomPartisipan->where('status', 'leave')->count();
            // Ambil data transaksi
            $this->transactions = Transaction::where('user_id', $user->id)->get();
            $this->transactionUnpaid = $this->transactions->where('status', 'unpaid')->count();
            $this->transactionProses = $this->transactions->where('status', 'payment-verification')->count();
            $this->transactionFailed = $this->transactions->where('status', 'failed')->count();
            $this->transactionSuccess = $this->transactions->where('status', 'success')->count();
        }   
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-page');
    }
}
