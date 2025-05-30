<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app.wrapper')]
class ProfilePage extends Component
{
    public function render()
    {
        return view('livewire.profile.profile-page');
    }
}
