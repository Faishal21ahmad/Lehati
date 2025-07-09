<?php

namespace App\Livewire\Room;

use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Rooms"])]
class ManageRoomPage extends Component
{
    use WithPagination;

    public $query = ''; // properti pencarian

    public function render()
    {
        $user = Auth::user();

        $rooms = Room::with('product') // eager load relasi
            ->where('user_id', $user->id)
            ->when($this->query, function ($queryBuilder) {
                $queryBuilder->where(function ($subQuery) {
                    $subQuery->where('room_code', 'like', '%' . $this->query . '%')
                        ->orWhere('status', 'like', '%' . $this->query . '%')
                        ->orWhereHas('product', function ($q) {
                            $q->where('product_name', 'like', '%' . $this->query . '%');
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.room.manage-room-page', [
            'rooms' => $rooms,
        ]);
    }
}
