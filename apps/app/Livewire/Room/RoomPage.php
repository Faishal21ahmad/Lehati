<?php

namespace App\Livewire\Room;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app.wrapper')]
class RoomPage extends Component
{
    public function render()
    {
        return view('livewire.room.room-page');
    }
}
