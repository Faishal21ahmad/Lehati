<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\ImageProduct;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => "Add Products"])]
class ProductAdd extends Component
{
    use WithFileUploads;

    public $name_product;
    public $quantity;
    public $units;
    public $description;
    public $fileproduct = [];

    public function mount()
    {
        $this->name_product = '';
        $this->quantity = '';
        $this->units = '';
        $this->description = '';
    }

    public function createProduct(): void
    {
        $validator = $this->validate([
            'name_product' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:1|max:999999',
            'units' => 'required|string',
            'description' => 'nullable|string|min:10|max:2000',
            'fileproduct' => 'required|array|min:1|max:5',
            'fileproduct.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name_product.required' => 'Nama produk wajib diisi',
            'name_product.string' => 'Nama produk harus berupa teks',
            'name_product.max' => 'Nama produk maksimal 255 karakter',
            'quantity.required' => 'Jumlah produk wajib diisi',
            'quantity.numeric' => 'Jumlah harus berupa angka',
            'quantity.min' => 'Jumlah minimal 1',
            'quantity.max' => 'Jumlah maksimal 999.999',
            'units.required' => 'Satuan produk wajib diisi',
            'units.string' => 'Satuan harus berupa teks',
            'description.string' => 'Deskripsi harus berupa teks',
            'description.min' => 'Deskripsi minimal 10 karakter',
            'description.max' => 'Deskripsi maksimal 2000 karakter',
            'fileproduct.required' => 'Harap unggah setidaknya 1 gambar produk',
            'fileproduct.array' => 'Format file tidak valid',
            'fileproduct.min' => 'Harap unggah setidaknya 1 gambar produk',
            'fileproduct.max' => 'Maksimal 5 gambar yang dapat diunggah',
            'fileproduct.*.image' => 'File harus berupa gambar (jpeg, png, jpg)',
            'fileproduct.*.mimes' => 'Format file yang diperbolehkan: jpeg, png, jpg',
            'fileproduct.*.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $user = Auth::user();

        // Buat produk terlebih dahulu
        $product = Product::create([
            'user_id' => $user->id,
            'product_name' => $this->name_product,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'units' => $this->units,
            'status' => 'available',
        ]);

        // Proses setiap file yang diunggah
        foreach ($this->fileproduct as $file) {
            // Generate nama file acak dengan ekstensi asli
            $randomName = Str::random(40) . '.' . $file->getClientOriginalExtension();

            // Simpan file ke storage/imageproduct
            $path = $file->storeAs('imageproduct', $randomName, 'public');

            // Simpan informasi gambar ke database
            ImageProduct::create([
                'product_id' => $product->id,
                'image_path' => $path // Menyimpan path relatif dari storage
            ]);
        }

        // Reset form setelah berhasil
        $this->reset([
            'name_product',
            'quantity',
            'units',
            'description',
            'fileproduct'
        ]);

        session()->flash('toast', [
            'id' => uniqid(),
            'message' => __('Product created successfully!'),
            'type' => 'success',
            'duration' => 5000
        ]);

        $this->redirectIntended(default: route('products', absolute: false), navigate: true);
    }


    public function render()
    {
        return view('livewire.products.product-add');
    }
}
