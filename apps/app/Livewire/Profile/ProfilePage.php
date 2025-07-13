<?php

namespace App\Livewire\Profile;

use Livewire\Livewire;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Profile"])]
class ProfilePage extends Component
{
    public string $name = '';
    public string $code_user = '';
    public string $email = '';
    public string $role = '';

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

            $this->dispatch(
                'showToast',
                message: 'Profile updated successfully!',
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
        return view('livewire.profile.profile-page');
    }
}
