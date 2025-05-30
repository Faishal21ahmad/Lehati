<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.home.wrapper')]
class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home.home-page');
    }
}
