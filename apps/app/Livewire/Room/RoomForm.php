<?php

namespace App\Livewire\Room;

use Carbon\Carbon;
use App\Models\Bid;
use App\Models\Room;
use App\Models\Product;
use Livewire\Component;
use App\Models\Participant;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.app', ['title' => "Room Information"])]
class RoomForm extends Component
{
    use WithPagination;

    public $roomId;
    public $coderoom, $partisipantjoin, $status, $room_notes, $user_id, $starting_price,  $min_bid_step, $product, $start_time, $end_time;
    public $products = [];
    public $partisipans, $countpartisipantjoin, $countpartisipantleave, $countpartisipantrejected;
    public $transaksiWinner;

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
            $this->countpartisipantleave    = $room->participants->where('status', 'leave')->count();
            $this->countpartisipantrejected = $room->participants->where('status', 'rejected')->count();

            $this->transaksiWinner = Bid::where('room_id', $this->roomId)
                ->where('is_winner', true)
                ->latest('created_at') // urutkan dari yang terbaru
                ->first();

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

    // Menyimpan data baru dan pembaruan data Room 
    public function save()
    {   // validasi input data Room
        $this->validate([
            'product' => 'required|exists:products,id',
            'starting_price' => 'required|numeric|min:0',
            'min_bid_step' => 'required|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'room_notes' => 'nullable|string|max:200',
        ], [
            // product
            'product.required' => 'Produk wajib dipilih.',
            'product.exists'   => 'Produk yang dipilih tidak valid.',
            // starting_price
            'starting_price.required' => 'Harga awal wajib diisi.',
            'starting_price.numeric'  => 'Harga awal harus berupa angka.',
            'starting_price.min'      => 'Harga awal tidak boleh kurang dari 0.',
            // min_bid_step
            'min_bid_step.required' => 'Kelipatan bid minimal wajib diisi.',
            'min_bid_step.numeric'  => 'Kelipatan bid minimal harus berupa angka.',
            'min_bid_step.min'      => 'Kelipatan bid minimal tidak boleh kurang dari 0.',
            // start_time
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'start_time.date'     => 'Format waktu mulai tidak valid.',
            // end_time
            'end_time.required' => 'Waktu berakhir wajib diisi.',
            'end_time.date'     => 'Format waktu berakhir tidak valid.',
            'end_time.after'    => 'Waktu berakhir harus setelah waktu mulai.',
            // room_notes
            'room_notes.string' => 'Catatan harus berupa teks.',
            'room_notes.max'    => 'Catatan maksimal 200 karakter.',
        ]);

        
        $this->coderoom = $this->roomId ? $this->coderoom : 'RM' . fake()->unique()->numberBetween(1000, 9999);
        $this->user_id = $this->user_id ?: Auth::user()->id;
        $this->product = (int) $this->product;

        try {
            Room::updateOrCreate(
                ['id' => $this->roomId],
                [
                    'room_code' => $this->coderoom,
                    'user_id' => $this->user_id,
                    'status' => !$this->roomId ? 'upcoming' : $this->status,
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

            $this->dispatch( // triger notifikasi 
                'showToast',
                message: $this->roomId ? __('Berhasil di Update') : __('Berhasil di Simpan'),
                type: 'success',
                duration: 5000
            );

            if (!$this->roomId) { // Jika room baru, redirect ke halaman edit dengan room_code
                session()->flash('toast', [ // triger notifikasi 
                    'id' => uniqid(), 
                    'message' => __($this->roomId ? 'Produk berhasil diupdate.' : 'Produk berhasil ditambahkan.'),
                    'type' => 'success',
                    'duration' => 5000
                ]);
                return redirect()->route('room.edit', ['coderoom' => $this->coderoom]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            
            $this->dispatch(
                'showToast',
                message: __('Gagal di simpan'),
                type: 'error',
                duration: 5000
            );
            return;
        }
    }

    // Menolak Atau mengeluarkan Partisipan dari Room
    public function rejectpartisipan($code = null)
    {
        try {
            Participant::updateOrCreate(
                [
                    'user_id' => $code,
                    'room_id' => $this->roomId
                ],
                [
                    'status' => 'rejected'
                ]
            );
            session()->flash('toast', [  // triger notifikasi
                'id' => uniqid(), 
                'message' => __('Berhasil Reject'),
                'type' => 'success',
                'duration' => 5000
            ]);
        } catch (ValidationException $e) {
            session()->flash('toast', [  // triger notifikasi
                'id' => uniqid(), 
                'message' => __('Gagal Reject'),
                'type' => 'error',
                'duration' => 5000
            ]);
        }
        $this->redirectIntended(default: route('room.edit', $this->coderoom, absolute: false));
    }

    // Memulai Lelang oleh Admin
    public function startbidding()
    {
        $timenow = Carbon::now();
        if ($this->status == 'ended') {
            session()->flash('toast', [  // triger notifikasi
                'id' => uniqid(), 
                'message' => __('The Room Has Ended'),
                'type' => 'error',
                'duration' => 5000
            ]);
            $this->redirectIntended(default: route('room.edit', $this->coderoom, absolute: false));
        } else {
            if ($timenow > $this->start_time) {
                Room::updateOrCreate(
                    [
                        'room_code' => $this->coderoom,
                    ],
                    [
                        'status' => 'ongoing'
                    ]
                );
                session()->flash('toast', [  // triger notifikasi
                    'id' => uniqid(), 
                    'message' => __('Auction is open'),
                    'type' => 'success',
                    'duration' => 5000
                ]);
                $this->redirectIntended(default: route('room.bidding', $this->coderoom, absolute: false));
            } else {
                $this->dispatch(  // triger notifikasi
                    'showToast',
                    message: "It's not time yet",
                    type: 'error', // 'error', 'success' ,'info'
                    duration: 5000
                );
            }
        }
    }

    // Membatalkan ruang lelang 
    public function cancelRoom()
    {
        // validasi status room whether status ended ? 
        // update status room to cancelled
        // update status partisipan to rejected
        // update status product to available
        if ($this->status == 'ended') { 
            session()->flash('toast', [  // triger notifikasi
                'id' => uniqid(), 
                'message' => __('The Room Has Ended'),
                'type' => 'error',
                'duration' => 5000
            ]);
            $this->redirectIntended(default: route('room.edit', $this->coderoom, absolute: false), navigate: false);
        } else {
            try {
                DB::beginTransaction();
                // update status room
                Room::updateOrCreate([
                    'room_code' => $this->coderoom,
                ], [
                    'status' => 'cancelled'
                ]);
                // update status seluruh partisipan 
                Participant::where('room_id', $this->roomId)
                    ->where('status', 'joined') 
                    ->update(['status' => 'rejected']);
                // update status product
                Product::updateOrCreate([
                    'id' => $this->product
                ], [
                    'status' => 'available'
                ]);
                
                session()->flash('toast', [ // triger notifikasi
                    'id' => uniqid(), 
                    'message' => __('Room is cancelled'),
                    'type' => 'error',
                    'duration' => 5000
                ]);
                $this->redirectIntended(default: route('room.edit', $this->coderoom, absolute: false), navigate: false);

                DB::commit();
            } catch (ValidationException $e) {
                DB::rollBack();
                $this->dispatch( // triger notifikasi
                    'showToast',
                    message: $e,
                    type: 'error', // 'error', 'success' ,'info'
                    duration: 5000
                );
            }
        }
    }

    public function render()
    {
        return view('livewire.room.room-form');
    }
}

// try {
//     DB::beginTransaction();
//     //model
//     DB::commit();
// } catch (ValidationException $e) {
//     DB::rollBack();
// }
