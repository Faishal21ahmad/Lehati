<?php

namespace App\Livewire\Room;

use App\Models\AuctionRoom;
use Livewire\Component;
use Livewire\Attributes\Layout;
use SebastianBergmann\CodeUnit\FunctionUnit;

#[Layout('components.layouts.home', ['title' => "Home"])]
class Room extends Component
{
    public $room;
    public function mount($coderoom)
    {
        $this->room = AuctionRoom::where('room_code', $coderoom)->first();
    }

    public function render()
    {
        return view('livewire.room.room');
    }
}
