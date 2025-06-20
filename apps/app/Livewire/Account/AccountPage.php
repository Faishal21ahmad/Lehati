<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => "Account"])]
class AccountPage extends Component
{
    public function render()
    {
        return view('livewire.account.account-page');
    }
}
