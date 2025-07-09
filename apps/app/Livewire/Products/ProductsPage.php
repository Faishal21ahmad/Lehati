<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => "Products"])]
class ProductsPage extends Component
{
    use WithPagination;
    public $query = '';

    public function render()
    {
        $products = Product::query()
            ->when($this->query, function ($query) {
                $query->where('product_name', 'like', '%' . $this->query . '%')
                    ->orWhere('description', 'like', '%' . $this->query . '%')
                    ->orWhere('quantity', 'like', '%' . $this->query . '%')
                    ->orWhere('status', 'like', '%' . $this->query . '%')
                    ->orWhere('units', 'like', '%' . $this->query . '%');
                    
            })
            ->orderBy('product_name', 'asc')
            ->paginate(10);

        return view('livewire.products.products-page', [
            'products' => $products, // pastikan ini DIKIRIM
        ]);

        // return view('livewire.products.products-page');
    }
}
