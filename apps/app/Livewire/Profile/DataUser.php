<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\UserData;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Profile Data"])]
class DataUser extends Component
{
    public $phone, $address, $nik, $gender, $bank, $bank_name, $bank_number;
    // Load inisialisasi data user
    public function mount(): void
    {
        $user = Auth::user();
        $userData = UserData::where('user_id', $user->id)->first();
        $this->phone = $userData->phone ?? '';
        $this->address = $userData->address ?? '';
        $this->nik = $userData->nik ?? '';
        $this->gender = $userData->gender ?? '';
        $this->bank = $userData->bank ?? '';
        $this->bank_name = $userData->bank_name ?? '';
        $this->bank_number = $userData->bank_number ?? '';
    }

    // Save or Update User Data
    public function updateUserData(): void
    {
        // Validasi input Data User
        $this->validate([
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'gender' => 'required|in:male,female',
            'bank' => 'required|string|max:40',
            'bank_name' => 'required|string|max:50',
            'bank_number' => 'required|string|max:40'
        ], [
            // Phone
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.string'   => 'Nomor telepon harus berupa teks.',
            'phone.max'      => 'Nomor telepon maksimal 15 karakter.',
            // Address
            'address.required' => 'Alamat wajib diisi.',
            'address.string'   => 'Alamat harus berupa teks.',
            'address.max'      => 'Alamat maksimal 255 karakter.',
            // NIK
            'nik.required' => 'NIK wajib diisi.',
            'nik.string'   => 'NIK harus berupa teks.',
            'nik.size'     => 'NIK harus terdiri dari 16 digit.',
            // Gender
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in'       => 'Jenis kelamin harus salah satu dari: male atau female.',
            // Bank
            'bank.required' => 'Nama bank wajib diisi.',
            'bank.string'   => 'Nama bank harus berupa teks.',
            'bank.max'      => 'Nama bank maksimal 40 karakter.',
            // Bank Name (Atas Nama)
            'bank_name.required' => 'Nama pemilik rekening wajib diisi.',
            'bank_name.string'   => 'Nama pemilik rekening harus berupa teks.',
            'bank_name.max'      => 'Nama pemilik maksimal 50 karakter.',
            // Bank Number (No Rekening)
            'bank_number.required' => 'Nomor rekening wajib diisi.',
            'bank_number.string'   => 'Nomor rekening harus berupa teks.',
            'bank_number.max'      => 'Nomor rekening maksimal 40 karakter.',
        ]);

        try {
            // load data user dari auth
            $user = Auth::user();
            // update atau simpan data user
            UserData::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'nik' => $this->nik,
                    'gender' => $this->gender,
                    'bank' => $this->bank,
                    'bank_name' => $this->bank_name,
                    'bank_number' => $this->bank_number
                ]
            );
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Updated successfully!',
                type: 'success', // 'error', 'success' ,'info'
                duration: 5000
            );

            // jika perubahan gagal tampilkan pesan error
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Validation failed: ' . $e->getMessage(),
                type: 'error', // 'error', 'success' ,'info'
                duration: 5000
            );
            return;
        }
    }

    public function render()
    {
        return view('livewire.profile.data-user');
    }
}
