<?php

namespace App\Livewire\Profile;

use Livewire\Livewire;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Profile"])]
class ProfilePage extends Component
{
    public $name, $code_user, $email, $role;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name ?? '';
        $this->code_user = $user->code_user ?? '';
        $this->email = $user->email ?? '';
        $this->role = $user->role->value ?? '';
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        try {
            $user = Auth::user();
            $user->update([
                'name' => $this->name,
                'updated_at' => now(),
            ]);

            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Profile updated successfully!',
                type: 'success', // 'error', 'success' ,'info'
                duration: 5000
            );
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
        return view('livewire.profile.profile-page');
    }
}
