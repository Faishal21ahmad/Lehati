<?php

namespace App\Livewire\Home;

use Carbon\Carbon;

use App\Models\Room;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.home', ['title' => "Home"])]
class HomePage extends Component
{
    public $room;
    public $roomupcoming = null;
    public $ongoing = null;
    public $query = '';

    public function render()
    {
        $time = Carbon::now();

        // Upcoming
        $this->roomupcoming = Room::with('product')
            ->where('start_time', '>', $time)
            ->where('status', 'upcoming')
            ->get();

        // Ongoing
        $this->ongoing = Room::with('product')
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->where('status', 'ongoing')
            ->get();

        // All Room + Search
        $rooms = Room::with('product') // eager load relasi
            ->when($this->query, function ($queryBuilder) {
                $queryBuilder->where(function ($subQuery) {
                    $subQuery->where('room_code', 'like', '%' . $this->query . '%')
                        ->orWhere('status', 'like', '%' . $this->query . '%')
                        ->orWhereHas('product', function ($q) {
                            $q->where('product_name', 'like', '%' . $this->query . '%');
                        });
                });
            })
            ->whereIn('status', ['upcoming', 'ongoing'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.home.home-page', [
            'rooms' => $rooms,
        ]);
    }
}
