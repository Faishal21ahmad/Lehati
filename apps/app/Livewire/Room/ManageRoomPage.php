<?php

namespace App\Livewire\Room;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => "Products"])]
class ManageRoomPage extends Component
{
    public $rooms = [];

    public function mount()
    {
        $user = Auth::user();
        $this->rooms = Room::where('user_id', $user->id)->get();
    }
    public function render()
    {
        return view('livewire.room.manage-room-page');
    }
}
