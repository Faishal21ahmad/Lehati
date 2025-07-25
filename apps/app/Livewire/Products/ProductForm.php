<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use App\Models\ImageProduct;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app', ['title' => "Products"])]
class ProductForm extends Component
{
    use WithFileUploads;
    public $productId, $product;
    public $product_name, $quantity, $units = 'kg', $description;
    public $newImages = [];
    public $existingImages = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->product = Product::with('images')->findOrFail($id);
            $this->productId = $this->product->id;
            $this->product_name = $this->product->product_name;
            $this->quantity = $this->product->quantity;
            $this->units = $this->product->units;
            $this->description = $this->product->description;
            $this->loadimage();
        }
    }
    // Function untuk memuat gambar yang sudah ada
    public function loadimage()
    {
        $this->existingImages = $this->product->images->map(function ($img) {
            return ['id' => $img->id, 'image_path' => $img->image_path];
        })->toArray();
    }
    // Function save update atau create Product
    public function save()
    {
        // validasi input Form Product
        $this->validate([
            'product_name' => 'required|string|max:40',
            'quantity' => 'required|integer|min:1',
            'units' => 'required|in:kg,ton,ons,kuintal',
            'description' => 'nullable|string|max:200',
            'newImages.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // product_name
            'product_name.required' => 'Nama produk wajib diisi.',
            'product_name.string'   => 'Nama produk harus berupa teks.',
            'product_name.max'      => 'Nama produk maksimal 40 karakter.',
            // quantity
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer'  => 'Jumlah harus berupa angka.',
            'quantity.min'      => 'Jumlah minimal adalah 1.',
            // units
            'units.required' => 'Satuan wajib dipilih.',
            'units.in'       => 'Satuan harus salah satu dari: kg, ton, ons, atau kuintal.',
            // description
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max'    => 'Deskripsi maksimal 200 karakter.',
            // newImages.*
            'newImages.*.image' => 'Setiap file harus berupa gambar.',
            'newImages.*.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'newImages.*.max'   => 'Ukuran setiap gambar maksimal 2MB.',
        ]);

        $user = Auth::user();
        $product = Product::updateOrCreate(
            ['id' => $this->productId],
            [
                'user_id' => $user->id,
                'product_name' => $this->product_name,
                'quantity' => $this->quantity,
                'units' => $this->units,
                'description' => $this->description,
                'status' => 'available',
            ]
        );


        if (!empty($this->newImages)) {
            foreach ($this->newImages as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        } else {
            // Simpan gambar default jika tidak ada upload
            $product->images()->create(['image_path' => 'products.png']);
        }


        session()->flash('toast', [ // triger notifikasi 
            'id' => uniqid(),
            'message' => __($this->productId ? 'Product successfully updated' : 'Product added successfully'),
            'type' => 'success', // 'error', 'success' ,'info'
            'duration' => 5000
        ]);
        $this->redirectIntended(default: route('product.edit', $product->id, absolute: false), navigate: false);
    }

    // Menghapus image
    public function removeImage($id)
    {
        $image = ImageProduct::find($id);
        if ($image) {
            // Simpan image ke storage 
            Storage::disk('public')->delete($image->image_path);
            $image->delete();

            // Perbarui ulang list existingImages dari database
            $this->existingImages = ImageProduct::where('product_id', $this->productId)
                ->get()
                ->map(fn($img) => [
                    'id' => $img->id,
                    'image_path' => $img->image_path,
                ])
                ->toArray();

            session()->flash('toast', [ // triger notifikasi 
                'id' => uniqid(),
                'message' => __('Image successfully deleted'),
                'type' => 'success',  // 'error', 'success' ,'info'
                'duration' => 5000
            ]);
        } else {
            session()->flash('toast', [ // triger notifikasi 
                'id' => uniqid(),
                'message' => __('Image Failed to delete'),
                'type' => 'danger',  // 'error', 'success' ,'info'
                'duration' => 5000
            ]);
        }
        $this->redirectIntended(default: route('product.edit', $this->productId, absolute: false), navigate: false);
    }

    public function render()
    {
        return view('livewire.products.product-form');
    }
}
