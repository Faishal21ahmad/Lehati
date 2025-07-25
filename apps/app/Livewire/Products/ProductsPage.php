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
    public $showModal = false;
    public $deleteId = '';
    public $produk = '';

    // konfirmasi delete
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->produk = Product::find($id)->product_name;
        $this->showModal = true;
    }
    // Action delete data product
    public function delete()
    {
        try {
            Product::findOrFail($this->deleteId)->delete();
            $this->deleteId = null;
            $this->showModal = false;
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Delete success !',
                type: 'success', // 'error', 'success' ,'info'
                duration: 5000
            );
        } catch (\Exception $e) {
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Cannot be deleted, because the data has been used',
                type: 'error', // 'error', 'success' ,'info'
                duration: 5000
            );
        }
    }

    public function render()
    {   // Ambil data Product + query search
        $products = Product::query()
            ->when($this->query, function ($query) {
                $query->where('product_name', 'like', '%' . $this->query . '%')
                    ->orWhere('description', 'like', '%' . $this->query . '%')
                    ->orWhere('quantity', 'like', '%' . $this->query . '%')
                    ->orWhere('status', 'like', '%' . $this->query . '%')
                    ->orWhere('units', 'like', '%' . $this->query . '%');
            })
            ->orderBy('status', 'asc')
            ->paginate(10);

        return view('livewire.products.products-page', [
            'products' => $products, // pastikan ini DIKIRIM
        ]);
    }
}
