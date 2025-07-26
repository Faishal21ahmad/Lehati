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
        try {
            $this->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);

            $status = Password::sendResetLink([
                'email' => $this->email,
            ]);

            if ($status === Password::RESET_LINK_SENT) {
                $this->dispatch(
                    'showToast',
                    message: 'Link reset password telah dikirim ke email Anda.',
                    type: 'success',
                    duration: 5000
                );
                session()->flash('success', 'Link reset password telah dikirim ke email Anda.');
            } else {
                $this->dispatch(
                    'showToast',
                    message: __($status), // tampilkan pesan error dari Laravel
                    type: 'error',
                    duration: 5000
                );
                $this->addError('email', __($status));
            }
        } catch (\Throwable $e) {
            // Tangani error tak terduga (misal koneksi mail server, invalid config, dsb)
            $this->dispatch(
                'showToast',
                message: 'Terjadi kesalahan saat mengirim link reset password. Silakan coba lagi.',
                type: 'error',
                duration: 5000
            );
            $this->addError('email', 'Terjadi kesalahan saat mengirim link reset password. Silakan coba lagi.');
            // Opsional: log error untuk debugging
            logger()->error('Gagal mengirim reset link: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}




