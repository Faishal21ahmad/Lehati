<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password as PasswordRule;

#[Layout('components.layouts.app', ['title' => "Profile Password"])]
class Password extends Component
{
    public $current_password, $password, $password_confirmation;

    public function updatePassword(): void
    {
        $validated = $this->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', PasswordRule::defaults(), 'confirmed'],
        ]);

        try {
            Auth::user()->update([
                'password' => Hash::make($validated['password']),
            ]);
            $this->reset('current_password', 'password', 'password_confirmation');
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Password updated successfully!',
                type: 'success', // 'error', 'success' ,'info'
                duration: 5000
            );
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: $e->validator->errors()->first(),
                type: 'danger',
                duration: 5000 // Durasi lebih panjang untuk error
            );
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.profile.password');
    }
}
