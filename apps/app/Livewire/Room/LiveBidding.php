<?php

namespace App\Livewire\Room;

use Carbon\Carbon;
use App\Models\Bid;
use App\Models\Room;
use Livewire\Component;
use App\Models\Participant;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.home', ['title' => "LiveBidding"])]
class LiveBidding extends Component
{
    public $room;
    public $product, $images, $bids, $topBid, $bidnew, $participant;


    public function mount($coderoom)
    {
        $this->room = Room::where('room_code', $coderoom)->firstOrFail();
        $user = Auth::user();
        $timenow = Carbon::now();


        // Pengecekan hanya untuk non-admin
        if ($user->role->value !== 'admin') {
            $isParticipant = Participant::where('user_id', $user->id)
                ->where('room_id', $this->room->id)
                ->where('status', 'joined')
                ->exists(); // true/false

            if (! $isParticipant) {
                abort(403, 'You do not have access to this room.');
            }
            if ($this->room->status == 'cancelled') {
                abort(403, 'Auction Room cancelled');
            }
            if ($this->room->status == 'ended') {
                // abort(403, 'Auction Room cancelled');
                $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false));
            }
            if ($timenow > $this->room->end_time) {
                $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false));
            }
        } else {
            if ($this->room->status == 'ended') {
                // abort(403, 'Auction Room cancelled');
                $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false));
            }
            if ($timenow > $this->room->end_time) {
                $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false));
            }
        }
        $this->participant = Participant::where('user_id', $user->id)
            ->where('room_id', $this->room->id)
            ->where('status', 'joined')
            ->first();

        $this->product = $this->room->product;
        $this->images = $this->room->product->images->map(function ($img) {
            return ['id' => $img->id, 'image_path' => $img->image_path];
        })->toArray();

        $this->bids = $this->room->bids()->orderBy('id', 'desc')->get();
        $this->topBid = $this->room->bids()->orderByDesc('id')->first();
    }

    public function saveNewBid()
    {
        $selisih = $this->bidnew - $this->topBid->amount;

        if ($this->bidnew < $this->topBid->amount) {
            $this->dispatch(
                'showToast',
                message: "Bids must not be below the highest price",
                type: 'error', // 'error', 'success' ,'info'
                duration: 5000
            );
            throw ValidationException::withMessages([
                'bidnew' => __('Bids must not be below the highest price'),
            ]);
        } else {
            if ($selisih <= $this->room->min_bid_step) {
                $this->dispatch(
                    'showToast',
                    message: "Minimum bid difference",
                    type: 'error', // 'error', 'success' ,'info'
                    duration: 5000
                );
                throw ValidationException::withMessages([
                    'bidnew' => __('Minimum bid difference Rp.' . number_format($this->room->min_bid_step, 0, ',', '.')),
                ]);
            } else {
                Bid::create([
                    'participan_id' => $this->participant->id,
                    'room_id' => $this->room->id,
                    'amount' => $this->bidnew,
                ]);

                session()->flash('toast', [
                    'id' => uniqid(), // Simpan ID di session
                    'message' => __('Success Submit'),
                    'type' => 'success',
                    'duration' => 5000
                ]);
                $this->redirectIntended(default: route('room.bidding', $this->room->room_code, absolute: false));
            }
        }
    }

    public function endRoom()
    {
        Room::updateOrCreate([
            'room_code' => $this->room->room_code
        ], [
            'status' => 'ended'
        ]);
        $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false));
    }

    public function render()
    {
        return view('livewire.room.live-bidding');
    }
}
