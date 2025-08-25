<?php

namespace App\Livewire\Room;

use App\Models\Product;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Rooms"])]
class ManageRoomPage extends Component // Halaman list Manajemen Room User
{
    use WithPagination;

    public $query = ''; // properti pencarian
    public $showModal = false;
    public $deleteId = '';
    public $roomcode = '';

    // function button konfirmasi delete 
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->roomcode = Room::find($id)->room_code;
        $this->showModal = true;
    }

    // Function button Delete 
    public function delete()
    {
        try {
            $rm = Room::find($this->deleteId);
            // update status product 
            Product::where('id', $rm->product_id)
                ->update(['status' => 'available']);
            // softdelete room
            Room::findOrFail($this->deleteId)->delete();
            $this->deleteId = null;
            $this->showModal = false;

            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Delete success !',
                type: 'success', // 'error', 'success' ,'info'
                duration: 5000
            );

        // jika data tidak bisa dihapus karena sudah ada relasi dengan table lain    
        } catch (\Exception $e) {
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Cannot be deleted, because the data has been used',
                type: 'error', // 'error', 'success' ,'info'
                duration: 5000
            );
        }
    }

    // Render data ke view
    public function render()
    {   // Ambil data Room + query search
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
