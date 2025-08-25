<?php

namespace App\Livewire\Room;

use App\Models\Bid;
use App\Models\Room;
use Livewire\Component;
use App\Models\Participant;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.home', ['title' => "LiveBidding"])]
class LiveBidding extends Component // Halaman Live Bidding pada Room oleh Admin dan Bidder/Participant
{
    public $room, $roomCode1, $room_code;
    public $product, $images;
    public $bids, $topBid, $participant, $bidmount, $bidnew;

    // Load Inisialisasi data Livewire
    public function mount($coderoom)
    {
        // Ambil data user yang sedang login
        $user = Auth::user();
        // Ambil data room berdasarkan room_code dari parameter
        $this->room = Room::where('room_code', $coderoom)->firstOrFail();
        // Simpan room_code ke properti
        $this->room_code = $coderoom;
        // Cek apakah waktu saat ini sudah melewati waktu berakhir room
        $isRoomEnded = now()->gt($this->room->end_time);

        // cek akses untuk admin jika room sudah berakhir atau dibatalkan maka direct ke halaman edit room 
        if ($user->role->value === 'admin' && (in_array($this->room->status, ['cancelled', 'ended']) || $isRoomEnded)) {
            session()->flash('toast', [
                'id' => uniqid(),
                'message' => __('Auction Room Has Ended'),
                'type' => 'error',
                'duration' => 5000
            ]);
            $this->redirectIntended(default: route('room.edit', $this->room->room_code, absolute: false), navigate: true);
        }

        // cek akses untuk bidder/participant selain admin yang tidak terdaftar pada room tersebut atau room sudah berakhir atau dibatalkan maka direct ke halaman detail room
        if ($user->role->value !== 'admin') {
            // cek data participant pada room tersebut
            $this->participant = Participant::where([
                ['user_id', $user->id],
                ['room_id', $this->room->id],
                ['status', 'joined']
            ])->first();
            // jika tidak ada data participant atau room sudah berakhir atau dibatalkan maka direct ke halaman detail room 
            if (! $this->participant) {
                abort(403, 'You do not have access to this room.');

                // cek kondisi room apakah sudah berakhir atau dibatalkan atau waktu sudah melewati end_time maka direct ke halaman detail room 
            } else if (in_array($this->room->status, ['cancelled', 'ended']) || $isRoomEnded) {
                session()->flash('toast', [
                    'id' => uniqid(),
                    'message' => __('Auction Room Has Ended'),
                    'type' => 'error',
                    'duration' => 5000
                ]);
                $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false), navigate: false);
            }
        }

        // Ambil data produk dari room 
        $this->product = $this->room->product;
        // Load data bid terbaru
        $this->loadBid();
        // Ambil data gambar produk
        $this->images = $this->room->product->images->map(function ($img) {
            return ['id' => $img->id, 'image_path' => $img->image_path];
        })->toArray();
    }

    // Load data bid terbaru 
    private function loadBid()
    {
        // Ambil seluruh data bid pada room tersebut  
        $this->bids = $this->room->bids()->latest()->get();
        // Ambil data bid tertinggi 
        $this->topBid = $this->bids->first();
        // ambil nominal bid tertinggi atau jika tidak ada maka gunakan harga awal
        $this->bidmount = $this->topBid->amount ?? $this->room->starting_price;
    }

    // Function button refresh bid
    public function refreshbid()
    {
        $this->loadBid();
    }

    // Function submit bid baru
    public function submitNewBid()
    {
        // Validasi input bid baru
        $this->validate([
            'bidnew' => 'required|numeric|min:0',
        ], [
            'bidnew.required' => 'Nominal bid wajib diisi.',
            'bidnew.numeric'  => 'Nominal bid harus berupa angka.',
            'bidnew.min'      => 'Nominal bid tidak boleh kurang dari 0.',
        ]);

        // memuat ulang data bid terbaru
        $this->loadBid();

        // Cek kondisi room dan validasi bid baru (berdasarkan status bid dan waktu berakhir)
        if (in_array($this->room->status, ['ended', 'cancelled']) || now()->gt($this->room->end_time)) {
            // menampilkan notifikasi error
            session()->flash('toast', [
                'id' => uniqid(),
                'message' => __('Room is closed or auction ended'),
                'type' => 'error',
                'duration' => 5000
            ]);
            // direct to room detail room
            $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false), navigate: false);

            // bid/penawaran yang di input kurang dari sama dengan bid tertinggi
        } elseif ($this->bidnew <= $this->bidmount) {
            // menampilkan notifikasi error
            $this->dispatch('showToast', message: "Bids must not be below the highest price", type: 'error', duration: 5000);
            throw ValidationException::withMessages([
                'bidnew' => __('Bids must not be below the highest price'),
            ]);

            // bid/penawaran yang di input kurang dari minimum selisih bid
        } elseif (($this->bidnew - $this->bidmount) <= $this->room->min_bid_step) {
            // menampilkan notifikasi error
            $this->dispatch('showToast', message: "Minimum bid difference", type: 'error', duration: 5000);
            throw ValidationException::withMessages([
                'bidnew' => __('Minimum bid difference Rp.' . number_format($this->room->min_bid_step, 0, ',', '.')),
            ]);

            // Jika semua kondisi lolos, simpan data bid baru
        } else {
            Bid::create([
                'participan_id' => $this->participant->id,
                'room_id' => $this->room->id,
                'amount' => $this->bidnew,
            ]);
        }

        // Memuat ulang data bid terbaru dan reset input bid baru
        $this->loadBid();
        $this->dispatch(
            'showToast',
            message: 'Bid Successful',
            type: 'success', // 'error', 'success' ,'info'
            duration: 5000
        );
        // Reset input bid baru
        $this->reset('bidnew');
    }

    // Function untuk mengakhiri room (hanya untuk admin)
    public function endRoom()
    {
        try {
            DB::beginTransaction();

            // Update status room menjadi 'ended'
            Room::updateOrCreate([
                'room_code' => $this->room->room_code
            ], [
                'status' => 'ended'
            ]);

            // panggil data bid tertinggi pada room tersebut 
            $bid = Bid::where('room_id', $this->room->id)
                ->latest('created_at')
                ->first();

            // jika ada bid tertinggi maka tandai sebagai pemenang dan buat transaksi
            if ($bid) {
                // update data bid sebagai pemenang
                Bid::updateOrCreate([
                    'id' => $bid->id,
                ], [
                    'is_winner' => true
                ]);
                // buat data transaksi untuk pemenang   
                Transaction::create([
                    'bid_id' => $bid->id,
                    'user_id' => $bid->participant->user->id,
                    'code_transaksi' => now()->format('dmy') . 'TRF' . fake()->unique()->numberBetween(1000, 9999),
                    'status' => 'unpaid',
                    'amount_final' => $bid->amount
                ]);
            }

            DB::commit();
            session()->flash('toast', [ // triger notifikasi 
                'id' => uniqid(),
                'message' => __('Room terminated'),
                'type' => 'success', // 'error', 'success' ,'info'
                'duration' => 5000
            ]);

            // direct to room edit page
            $this->redirectIntended(default: route('room.edit', $this->room->room_code, absolute: false), navigate: false);

            // jika ada error pada proses diatas
        } catch (ValidationException $e) {
            DB::rollBack();
            $this->dispatch(
                'showToast',
                message: 'Failed to terminate room',
                type: 'error', // 'error', 'success' ,'info'
                duration: 5000
            );
        }
    }

    // Render view Livewire
    public function render()
    {
        return view('livewire.room.live-bidding');
    }
}
