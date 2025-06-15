<?php

namespace App\Livewire\Room;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => "Manage Room"])]
class ManageRoomPage extends Component
{
    public function render()
    {
        return view('livewire.room.manage-room-page');
    }
}
