<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;


#[Layout('components.layouts.auth', ['title' => "Forgot Password"])]
class ForgotPassword extends Component
{
    public string $email = '';
    public string $status = '';

    public function sendResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        // Kirim link reset password
        $status = Password::sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = __($status);
            session()->flash('success', 'Link reset password telah dikirim ke email Anda.');
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}

