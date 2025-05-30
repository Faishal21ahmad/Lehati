<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app.wrapper')]
class TransactionPage extends Component
{
    public function render()
    {
        return view('livewire.transaction.transaction-page');
    }
}
