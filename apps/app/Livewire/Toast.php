<?php

namespace App\Livewire;

use Livewire\Component;

class Toast extends Component
{
    public $toasts = [];
    protected $listeners = ['showToast' => 'show'];
    public function mount()
    {
        if (session()->has('toast')) {
            $toast = session('toast');
            $this->toasts[] = $toast;
            $this->dispatch('startToastTimer', toastId: $toast['id'], duration: $toast['duration']);
        }
    }

    public function show($message, $type = 'success', $duration = 3000)
    {
        $this->toasts[] = [
            'id' => uniqid(),
            'message' => $message,
            'type' => $type,
            'duration' => $duration,
            'time' => now()->toDateTimeString()
        ];
        // Auto remove toast after duration
        $this->dispatch('startToastTimer', toastId: end($this->toasts)['id'], duration: $duration);
    }

    public function remove($toastId)
    {
        $this->toasts = array_filter($this->toasts, fn($toast) => $toast['id'] !== $toastId);
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
