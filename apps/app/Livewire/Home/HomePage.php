<?php

namespace App\Livewire\Home;

use App\Models\Room;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.home', ['title' => "Home"])]
class HomePage extends Component
{
    public $room;
    public $roomupcoming;

    public function mount(): void
    {
        $this->room = Room::get();
        $this->roomupcoming = Room::where('status', 'upcoming')->get();
    }



    public function render()
    {
        return view('livewire.home.home-page');
    }
}
