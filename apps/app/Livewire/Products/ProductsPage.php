<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Products"])]
class ProductsPage extends Component
{
    public $products = [];
    public $auctioneerData;

    public function mount()
    {
        $user = Auth::user();
        $this->products = Product::where('auctioneer_id', $user->auctioneerData->id)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.products.products-page');
    }
}
