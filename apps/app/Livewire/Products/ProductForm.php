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

    public $productId;
    public $product_name, $quantity, $units = 'kg', $description;
    public $newImages = [];
    public $existingImages = [];

    public function mount($id = null)
    {
        if ($id) {
            $product = Product::with('images')->findOrFail($id);
            $this->productId = $product->id;
            $this->product_name = $product->product_name;
            $this->quantity = $product->quantity;
            $this->units = $product->units;
            $this->description = $product->description;
            // $this->existingImages = $product->images->pluck('image_path', 'id')->toArray();
            $this->existingImages = $product->images->map(function ($img) {
                return ['id' => $img->id, 'image_path' => $img->image_path];
            })->toArray();
        }
    }

    public function save()
    {
        $this->validate([
            'product_name' => 'required|string|max:40',
            'quantity' => 'required|integer|min:1',
            'units' => 'required|in:kg,ton,ons,ikat',
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
            'units.in'       => 'Satuan harus salah satu dari: kg, ton, ons, atau ikat.',

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
        }

        // session()->flash('success', $this->productId ? 'Produk berhasil diupdate.' : 'Produk berhasil ditambahkan.');
        session()->flash('toast', [
            'id' => uniqid(), // Simpan ID di session
            'message' => __($this->productId ? 'Produk berhasil diupdate.' : 'Produk berhasil ditambahkan.'),
            'type' => 'success',
            'duration' => 5000
        ]);
        // $this->redirectIntended(default: route('product.edit', ['id' => $product->id], absolute: false), navigate: true);
        return redirect()->route('product.edit', ['id' => $product->id]);
    }

    public function removeImage($id)
    {
        $image = ImageProduct::find($id);
        if ($image) {
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

            session()->flash('toast', [
                'id' => uniqid(), // Simpan ID di session
                'message' => __('Gambar berhasil dihapus.'),
                'type' => 'success',
                'duration' => 5000
            ]);
        } else {
            session()->flash('toast', [
                'id' => uniqid(), // Simpan ID di session
                'message' => __('Gambar Gagal dihapus.'),
                'type' => 'danger',
                'duration' => 5000
            ]);
        }
        $this->redirectIntended(default: route('product.edit', $this->productId, absolute: false));
    }


    public function render()
    {
        return view('livewire.products.product-form');
    }
}
