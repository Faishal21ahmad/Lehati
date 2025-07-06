<?php

namespace App\Livewire\Room;

use App\Models\Participant;
use App\Models\Room as Rooms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use SebastianBergmann\CodeUnit\FunctionUnit;

#[Layout('components.layouts.home', ['title' => "Home"])]
class Room extends Component
{
    public $room;
    public $images = [];
    public $partisipants = [];


    public function mount($coderoom)
    {
        $this->room = Rooms::where('room_code', $coderoom)->first();
        if (!$this->room) {
            abort(404, 'Room not found');
        }


        $this->images = $this->room->product->images->map(function ($img) {
            return ['id' => $img->id, 'image_path' => $img->image_path];
        })->toArray();

        $this->partisipants = $this->room->partisipants;
    }

    public function joinRoom()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        } elseif (!$user->userdata) {
            session()->flash('toast', [
                'id' => uniqid(), // Simpan ID di session
                'message' => __('Update Your Data !'),
                'type' => 'error',
                'duration' => 5000
            ]);
            $this->redirectIntended(default: route('profile.data', absolute: false), navigate: true);
        }

        Participant::updateOrCreate(
            [
                'user_id' => $user->id,
                'room_id' => $this->room->id,
            ],
            [
                'status' => 'joined',
            ]
        );

        $this->dispatch(
            'showToast',
            message: 'Joined Room !',
            type: 'success', // 'error', 'success' ,'info'
            duration: 5000
        );
    }

    public function leaveRoom()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Participant::where('user_id', $user->id)
            ->where('room_id', $this->room->id)
            ->update(['status' => 'left']);

        $this->dispatch(
            'showToast',
            message: 'Left Room !',
            type: 'success', // 'error', 'success' ,'info'
            duration: 5000
        );
    }
    public function isJoined()
    {
        $user = Auth::user();
        return $this->room
            ->participants()
            ->where('user_id', $user->id)
            ->where('status', 'joined')
            ->exists();
    }


    public function render()
    {
        return view('livewire.room.room');
    }
}
