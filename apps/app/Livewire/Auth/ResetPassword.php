<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.auth', ['title' => "Reset Password"])]
class ResetPassword extends Component
{
    public string $token;
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $status = '';

    public function mount($token): void
    {
        $this->token = $token;
        if (! $this->token) {
            abort(404, 'Token tidak ditemukan.');
        }
        // Ambil email dari request jika ada
        $this->email = request()->query('email', '');
    }

    public function resetPassword()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Reset password
        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('toast', [
                'id' => uniqid(), // Simpan ID di session
                'message' => __('Password berhasil direset. Silakan login dengan password baru.'),
                'type' => 'success',
                'duration' => 5000
            ]);
            return redirect()->route('login');
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
