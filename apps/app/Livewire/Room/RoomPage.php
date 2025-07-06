<?php

namespace App\Livewire\Room;

use Livewire\Component;
use App\Models\Participant;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Room"])]
class RoomPage extends Component
{
    public $partisipans;


    public function mount()
    {
        $user = Auth::user();
        $this->partisipans = Participant::where('user_id', $user->id)->get();
        // You can initialize any properties or perform actions when the component is mounted

    }


    public function render()
    {
        return view('livewire.room.room-page');
    }
}
