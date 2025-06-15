<?php

namespace App\Livewire\Userup;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => "Userup"])]
class UserupPage extends Component
{
    public function render()
    {
        return view('livewire.userup.userup-page');
    }
}
