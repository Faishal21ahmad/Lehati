<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use App\Models\ImageProduct;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.app', ['title' => "Add Products"])]
class ProductDetail extends Component
{
    use WithFileUploads;

    public $name_product;
    public $quantity;
    public $units;
    public $description;
    public $fileproduct = [];
    
    public function mount($id)
    {
        // Reset form setelah berhasil

        $product = Product::where('id', $id)->with('images')->first();
        $this->name_product = $product->product_name;
        $this->quantity = $product->quantity ;
        $this->units = $product->units;
        $this->description = $product->description;
        $this->fileproduct = $product->images->toArray();
    }

    public function updateProduct() {
        dd($this->all());
    }
    
    public function render()
    {
        return view('livewire.products.product-detail');
    }
}
