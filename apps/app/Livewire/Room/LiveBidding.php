<?php

namespace App\Livewire\Room;

use App\Events\BidNew;
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
class LiveBidding extends Component
{
    public $room, $roomCode1, $room_code;
    public $product, $images;
    public $bids, $topBid, $participant, $bidmount, $bidnew;

    public function mount($coderoom)
    {
        $user = Auth::user();
        $this->room = Room::where('room_code', $coderoom)->firstOrFail();
        $this->room_code = $coderoom;

        $isRoomEnded = now()->gt($this->room->end_time);
        if ($user->role->value === 'admin' && (in_array($this->room->status, ['cancelled', 'ended']) || $isRoomEnded)) {
            session()->flash('toast', [
                'id' => uniqid(),
                'message' => __('Auction Room Has Ended'),
                'type' => 'error',
                'duration' => 5000
            ]);
            $this->redirectIntended(default: route('room.edit', $this->room->room_code, absolute: false), navigate: true);
        }

        if ($user->role->value !== 'admin') {
            $this->participant = Participant::where([
                ['user_id', $user->id],
                ['room_id', $this->room->id],
                ['status', 'joined']
            ])->first();

            if (! $this->participant) {
                abort(403, 'You do not have access to this room.');
            } else if (in_array($this->room->status, ['cancelled', 'ended']) || $isRoomEnded) {
                // abort(403, 'Auction Room Has Ended');
                session()->flash('toast', [
                    'id' => uniqid(),
                    'message' => __('Auction Room Has Ended'),
                    'type' => 'error',
                    'duration' => 5000
                ]);
                $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false), navigate: false);
            }
        }

        $this->product = $this->room->product;
        $this->loadBid();
        $this->images = $this->room->product->images->map(function ($img) {
            return ['id' => $img->id, 'image_path' => $img->image_path];
        })->toArray();
    }

    private function loadBid()
    {
        $this->bids = $this->room->bids()->latest()->get();
        $this->topBid = $this->bids->first();
        $this->bidmount = $this->topBid->amount ?? $this->room->starting_price;
    }

    public function refreshbid()
    {
        $this->loadBid();
    }

    public function submitNewBid()
    {
        $this->validate([
            'bidnew' => 'required|numeric|min:0',
        ], [
            'bidnew.required' => 'Nominal bid wajib diisi.',
            'bidnew.numeric'  => 'Nominal bid harus berupa angka.',
            'bidnew.min'      => 'Nominal bid tidak boleh kurang dari 0.',
        ]);

        $this->loadBid();

        if (in_array($this->room->status, ['ended', 'cancelled']) || now()->gt($this->room->end_time)) {
            session()->flash('toast', [
                'id' => uniqid(),
                'message' => __('Room is closed or auction ended'),
                'type' => 'error',
                'duration' => 5000
            ]);

            $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false), navigate: false);
        } elseif ($this->bidnew <= $this->bidmount) {
            $this->dispatch('showToast', message: "Bids must not be below the highest price", type: 'error', duration: 5000);
            throw ValidationException::withMessages([
                'bidnew' => __('Bids must not be below the highest price'),
            ]);
        } elseif (($this->bidnew - $this->bidmount) <= $this->room->min_bid_step) {
            $this->dispatch('showToast', message: "Minimum bid difference", type: 'error', duration: 5000);
            throw ValidationException::withMessages([
                'bidnew' => __('Minimum bid difference Rp.' . number_format($this->room->min_bid_step, 0, ',', '.')),
            ]);
        } else {
            Bid::create([
                'participan_id' => $this->participant->id,
                'room_id' => $this->room->id,
                'amount' => $this->bidnew,
            ]);
        }
        $this->loadBid();
        $this->dispatch(
            'showToast',
            message: 'Bid Successful',
            type: 'success', // 'error', 'success' ,'info'
            duration: 5000
        );
        $this->reset('bidnew');
    }

    public function endRoom()
    {
        try {
            DB::beginTransaction();
            Room::updateOrCreate([
                'room_code' => $this->room->room_code
            ], [
                'status' => 'ended'
            ]);
            $bid = Bid::where('room_id', $this->room->id)
                ->latest('created_at') // urutkan dari yang terbaru
                ->first(); // ambil satu saja

            if ($bid) {
                Bid::updateOrCreate([
                    'id' => $bid->id,
                ], [
                    'is_winner' => true
                ]);

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
            $this->redirectIntended(default: route('room.edit', $this->room->room_code, absolute: false), navigate: false);
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

    public function render()
    {
        return view('livewire.room.live-bidding');
    }
}
