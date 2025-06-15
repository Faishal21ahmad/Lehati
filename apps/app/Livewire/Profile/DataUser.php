<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\UserData;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Profile Data"])]
class DataUser extends Component
{
    public string $phone = '';
    public string $address = '';
    public string $nik = '';
    public string $gender = '';


    public function mount(): void
    {
        $user = Auth::user();
        $userData = UserData::where('user_id', $user->id)->first();

        $this->phone = $userData->phone ?? '';
        $this->address = $userData->address ?? '';
        $this->nik = $userData->nik ?? '';
        $this->gender = $userData->gender ?? '';
    }

    public function updateUserData(): void
    {
        $validate = $this->validate([
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:16'],
            'gender' => ['string', 'max:10']
        ]);


        try {
            $user = Auth::user();
            $userData = UserData::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $validate['phone'],
                    'address' => $validate['address'],
                    'nik' => $validate['nik'],
                    'gender' => $validate['gender']
                ]
            );

            $this->dispatch(
                'showToast',
                message: 'Updated successfully!',
                type: 'success', // 'error', 'success' ,'info'
                duration: 5000
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            $this->dispatch(
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
