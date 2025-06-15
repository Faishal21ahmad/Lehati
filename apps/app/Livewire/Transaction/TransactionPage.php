<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app',  ['title' => "Transaction"])]
class TransactionPage extends Component
{
    public function render()
    {
        return view('livewire.transaction.transaction-page');
    }
}
