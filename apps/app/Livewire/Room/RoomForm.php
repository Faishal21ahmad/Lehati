<?php

namespace App\Livewire\Room;

use App\Models\Room;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Room"])]
class RoomForm extends Component
{
    use WithPagination;


    public $roomId;
    public $coderoom, $partisipantjoin, $status, $room_notes, $user_id, $starting_price,  $min_bid_step, $product, $start_time, $end_time;
    public $products = [];
    public $partisipans, $countpartisipantjoin, $countpartisipantleave, $countpartisipantrejected;

    public function mount($coderoom = null)
    {
        $user = Auth::user();

        if ($coderoom) {
            $room = Room::where('room_code', $coderoom)->firstOrFail();
            // Load room data i f coderoom is provided
            $this->roomId = $room->id;
            $this->coderoom = $room->room_code;
            $this->user_id = $room->user_id;
            $this->product = $room->product_id;
            $this->status = $room->status;
            $this->starting_price = $room->starting_price;
            $this->min_bid_step = $room->min_bid_step;
            $this->room_notes = $room->room_notes;
            $this->start_time = $room->start_time;
            $this->end_time = $room->end_time;

            $this->partisipantjoin = $room->participants->where('status', 'joined');

            $this->countpartisipantjoin     = $room->participants->where('status', 'joined')->count();
            $this->countpartisipantleave    = $room->participants->where('status', 'left')->count();
            $this->countpartisipantrejected = $room->participants->where('status', 'rejected')->count();


            $this->products = Product::where(['user_id' => $user->id])
                ->get()
                ->map(function ($product) {
                    return [
                        'value' => $product->id,
                        'label' => $product->product_name,
                    ];
                })
                ->toArray();
        } else {
            $this->product = '';
            $this->products = Product::where(['user_id' => $user->id, 'status' => 'available'])
                ->get()
                ->map(function ($product) {
                    return [
                        'value' => $product->id,
                        'label' => $product->product_name,
                    ];
                })
                ->toArray();
        }
    }

    public function save()
    {
        // $this->validate([
        //     'coderoom' => 'required|string|max:255',
        //     'product' => 'required|exists:products,id',
        //     'starting_price' => 'required|numeric|min:0',
        //     'min_bid_step' => 'required|numeric|min:0',
        //     'room_notes' => 'nullable|string|max:1000',
        //     'start_time' => 'required|date',
        //     'end_time' => 'required|date|after:start_time',
        // ]);

        // Siapkan nilai room_code
        $this->coderoom = $this->roomId ? $this->coderoom : 'RM' . fake()->unique()->numberBetween(1000, 9999);
        $this->user_id = $this->user_id ?: Auth::user()->id;
        $this->product = (int) $this->product;

        // dd($this);
        try {
            Room::updateOrCreate(
                ['id' => $this->roomId],
                [
                    'room_code' => $this->coderoom,
                    'user_id' => $this->user_id,
                    'status' => 'upcoming',
                    'room_notes' => $this->room_notes,
                    'product_id' => $this->product,
                    'starting_price' => $this->starting_price,
                    'min_bid_step' => $this->min_bid_step,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                ]
            );

            Product::updateOrCreate(
                ['id' => $this->product],
                [
                    'status' => 'use',
                ]
            );

            $this->dispatch(
                'showToast',
                message: $this->roomId ? __('Berhasil di Update') : __('Berhasil di Simpan'),
                type: 'success',
                duration: 5000
            );

            if (!$this->roomId) {
                // Jika room baru, redirect ke halaman edit dengan room_code
                session()->flash('toast', [
                    'id' => uniqid(), // Simpan ID di session
                    'message' => __($this->roomId ? 'Produk berhasil diupdate.' : 'Produk berhasil ditambahkan.'),
                    'type' => 'success',
                    'duration' => 5000
                ]);
                return redirect()->route('room.edit', ['coderoom' => $this->coderoom]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            $this->dispatch(
                'showToast',
                message: __('Gagal di simpan'),
                type: 'danger',
                duration: 5000
            );
            return;
        }
    }
    public function render()
    {
        return view('livewire.room.room-form');
    }
}
