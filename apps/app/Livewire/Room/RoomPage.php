<?php

namespace App\Livewire\Room;

use Livewire\Component;
use App\Models\Participant;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => "Room"])]
class RoomPage extends Component // Halaman List Room User
{
    use WithPagination;
    public $query = '';

    public function updatingQuery()
    {
        $this->resetPage(); // reset ke page 1 saat search berubah
    }

    public function render()
    {   // Ambil data Room + query search
        $user = Auth::user();

        $partisipans = Participant::with(['room.product'])
            ->where('user_id', $user->id)
            ->when($this->query, function ($q) {
                $search = $this->query;

                $q->where(function ($query) use ($search) {
                    $query->where('status', 'like', "%{$search}%")
                        ->orWhereHas(
                            'room',
                            fn($q) =>
                            $q->where('room_code', 'like', "%{$search}%")
                        )
                        ->orWhereHas(
                            'room.product',
                            fn($q) =>
                            $q->where('product_name', 'like', "%{$search}%")
                        );
                });
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('livewire.room.room-page', [
            'partisipans' => $partisipans,
        ]);
    }
}
