<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app.wrapper')]
class ProductsPage extends Component
{
    public function render()
    {
        return view('livewire.products.products-page');
    }
}
