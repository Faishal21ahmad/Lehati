<?php

namespace App\Livewire\Room;

use Carbon\Carbon;
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
    public $room;
    public $product, $images, $bids, $topBid, $bidnew, $participant, $topBidAmount;

    public function mount($coderoom)
    {
        $this->room = Room::where('room_code', $coderoom)->firstOrFail();
        $user = Auth::user();
        $timenow = Carbon::now();

        // Pengecekan untuk role user
        if ($user->role->value !== 'admin') {
            // Pengecekan User yang login apakah termasuk peserta Room Lelang 
            $isParticipant = Participant::where('user_id', $user->id)
                ->where('room_id', $this->room->id)
                ->where('status', 'joined')
                ->exists(); // true/false

            // Penolakan Jika User bukan peserta 
            if (! $isParticipant) {
                abort(403, 'You do not have access to this room.');
            }
            // Penolakan jika status Room telah cancelled
            if ($this->room->status == 'cancelled') {
                abort(403, 'Auction Room cancelled');
            }
            // Penolakan 
            if ($this->room->status === 'ended' || $timenow > $this->room->end_time) {
                return $this->redirectIntended(route('room.detail', $this->room->room_code, absolute: false));
            }

        // pengecekan selain role admin 
        } else {
            if ($this->room->status === 'ended' || $timenow > $this->room->end_time) {
                return $this->redirectIntended(route('room.edit', $this->room->room_code, absolute: false));
            }
        }

        $this->product = $this->room->product;
        $this->bids = $this->room->bids()->orderBy('id', 'desc')->get();
        $this->topBid = $this->room->bids()->orderByDesc('id')->first();
        $this->topBidAmount = $this->topBid->amount ?? $this->room->starting_price;

        $this->participant = Participant::where('user_id', $user->id)
            ->where('room_id', $this->room->id)
            ->where('status', 'joined')
            ->first();

        $this->images = $this->room->product->images->map(function ($img) {
            return ['id' => $img->id, 'image_path' => $img->image_path];
        })->toArray();
    }

    // save databid baru 
    public function saveNewBid()
    {
        $this->validate([
            'bidnew' => 'required|numeric|min:0',
        ], [
            'bidnew.required' => 'Nominal bid wajib diisi.',
            'bidnew.numeric'  => 'Nominal bid harus berupa angka.',
            'bidnew.min'      => 'Nominal bid tidak boleh kurang dari 0.',
        ]);

        if ($this->room->status === 'ended' || $this->room->status === 'cancelled') {
            session()->flash('toast', [
                'id' => uniqid(), // Simpan ID di session
                'message' => __('Room ' . $this->room->status),
                'type' => 'success',
                'duration' => 5000
            ]);
            return $this->redirectIntended(default: route('room.detail', $this->room->room_code, absolute: false));
        } else {
            // $amount = $this->topBid->amount ?? $this->room->starting_price;
            $selisih = $this->bidnew - $this->topBidAmount;
            if ($this->bidnew < $this->topBidAmount) {
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
    }

    // function button untuk endRoom (Mengakhiri Room)
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

            $this->redirectIntended(default: route('room.edit', $this->room->room_code, absolute: false));

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            $this->dispatch(
                'showToast',
                message: $e,
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


// try {
//     DB::beginTransaction();

//     $this->redirectIntended(default: route('#', $this->, absolute: false));
//     DB::commit();
// } catch (ValidationException $e) {
//     DB::rollBack();
//     $this->dispatch(
//         'showToast',
//         message: $e,
//         type: 'error', // 'error', 'success' ,'info'
//         duration: 5000
//     );
// }