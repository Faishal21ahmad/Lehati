<?php

namespace App\Livewire\Room;

use Carbon\Carbon;
use App\Models\Bid;
use Livewire\Component;
use App\Models\Participant;
use App\Models\Room as Rooms;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.home', ['title' => "Detail Product"])]
class Room extends Component
{
    public $room;
    public $images = [];
    public $partisipants = [];
    public $transaksiWinner;
    public $user;

    public function mount($coderoom)
    {
        $this->room = Rooms::where('room_code', $coderoom)->first();
        $this->partisipants = $this->room->partisipants;
        $this->user = Auth::user();

        if (!$this->room) {
            abort(404, 'Room not found');
        }
        $this->images = $this->room->product->images->map(function ($img) {
            return ['id' => $img->id, 'image_path' => $img->image_path];
        })->toArray();
        $this->transaksiWinner = Bid::where('room_id', $this->room->id)
            ->where('is_winner', true)
            ->latest('created_at') // urutkan dari yang terbaru
            ->first();
    }

    // function button joinRoom (user join room lelang)
    public function joinRoom()
    {
        // Pengecekan jika user belum login 
        if (!$this->user) {
            return redirect()->route('login');

        // Pengecekan jika user data belum terisi / belum melengakapi data user
        } elseif (!$this->user->userdata) {
            session()->flash('toast', [ // triger notifikasi 
                'id' => uniqid(),
                'message' => __('Update Your Data !'),
                'type' => 'error',  // 'error', 'success' ,'info'
                'duration' => 5000
            ]);
            $this->redirectIntended(default: route('profile.data', absolute: false), navigate: true);
        }

        Participant::updateOrCreate(
            [
                'user_id' => $this->user->id,
                'room_id' => $this->room->id,
            ],
            [
                'status' => 'joined',
            ]
        );

        $this->dispatch( // triger notifikasi 
            'showToast',
            message: 'Joined Room !',
            type: 'success', // 'error', 'success' ,'info'
            duration: 5000
        );
    }
    // function button leaveRoom (keluar room)
    public function leaveRoom()
    {
        if (!$this->user) {
            return redirect()->route('login');
        }
        // update status participan user 
        Participant::where('user_id', $this->user->id)
            ->where('room_id', $this->room->id)
            ->update(['status' => 'leave']);
        
        $this->dispatch( // triger notifikasi 
            'showToast', 
            message: 'Leave Room !',
            type: 'success', // 'error', 'success' ,'info'
            duration: 5000
        );
    }

    // pengecekan apakah user join room ini
    public function isJoined()
    {
        return $this->room
            ->participants()
            ->where('user_id', $this->user->id)
            ->where('status', 'joined')
            ->exists();
    }

    // function button starbidding (memulai ke halaman Livebidding)
    public function startbidding()
    {
        $timenow = Carbon::now();
        // Pengecekan waktu mulai lelang 
        if ($timenow > $this->room->start_time) {
            // Pengecekan status Room lelang 
            if ($this->room->status === 'ongoing') {
                session()->flash('toast', [ // triger notifikasi 
                    'id' => uniqid(), 
                    'message' => __('Start bid'),
                    'type' => 'success', // 'error', 'success' ,'info'
                    'duration' => 5000
                ]);
                $this->redirectIntended(default: route('room.bidding', $this->room->room_code, absolute: false));
            } else {
               
                $this->dispatch( // triger notifikasi 
                    'showToast',
                    message: "Auction has not been opened by admin, Please wait",
                    type: 'info', // 'error', 'success' ,'info'
                    duration: 5000
                );
            }
        } else {
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: "It's not time yet",
                type: 'error', // 'error', 'success' ,'info'
                duration: 5000
            );
        }
    }

    public function render()
    {
        return view('livewire.room.room');
    }
}
