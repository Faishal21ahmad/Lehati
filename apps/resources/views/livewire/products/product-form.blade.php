<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header
    :title="$productId ? __('Detail Product') : __('Add Product')"
    :description="$productId ? __('Detail Your Product') : __('Create New Your Product')" />

    <div class="max-w-7xl flex lg:flex-row flex-col-reverse gap-4 mt-4">
        {{-- Form untuk menambah atau mengedit produk --}}
        <div class="w-full">
            <form wire:submit.prevent="save" enctype="multipart/form-data">
                <x-input.input type="text" id="product_name" label="Name Product" placeholder="Cabe" required error="{{ $errors->first('name_product') }}"/>
                <div class="flex gap-4 w-full">
                    <x-input.input type="number" id="quantity" name="quantity" label="Quantity" placeholder="1" required error="{{ $errors->first('quantity') }}"/>
                    <x-input.select name="units" id="units" label="Unit" placeholder="Pilih unit" 
                        :options="[
                            ['value' => 'kg', 'label' => 'Kg'],
                            ['value' => 'ton', 'label' => 'Ton'],
                            ['value' => 'ons', 'label' => 'Ons'],
                            ['value' => 'kuintal', 'label' => 'Kuintal']
                        ]" 
                        error="{{ $errors->first('units') }}" />
                </div>
                <x-input.textarea name="description" id="description" label="Description" placeholder="" error="{{ $errors->first('description') }}"/>
                <x-input.file id="newImages" label="Picture Product" accept="image/*" :multiple="true" helpText="Upload your photo product (jpeg, png, jpg)" error="{{ $errors->first('newImages.*') }}"/>
    
                {{-- Preview gambar baru --}}
                @if ($newImages)
                    <div class="flex gap-2 mt-2 flex-wrap">
                        @foreach ($newImages as $img)
                            <img src="{{ $img->temporaryUrl() }}" class="w-20 h-20 object-cover rounded shadow" />
                        @endforeach
                    </div>
                @endif
                <div class="mt-2">
                    <x-button.btn type="submit" class="">{{ $productId ? 'Update' : 'Simpan' }}</x-button.btn>
                    <x-button.btnaccorlink navigate=true type="button" href="{{ Route('products') }}" color="yellow">Back</x-button.btnaccorlink>
                </div>
            </form>
        </div>
        <div class="w-full">
            {{-- Gambar yang sudah ada --}}
            @if ($existingImages)
                <x-carousel.carousel :fileproduct="$existingImages" class="w-full"  />
                <div class="mt-4 ">
                    <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar yang sudah ada:</p>
                    <div class="flex gap-2 flex-wrap overflow-auto">
                        {{-- Tampilkan gambar yang sudah ada --}}
                        @foreach ($existingImages as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image['image_path']) }}" class="w-20 h-20 object-cover rounded shadow" />
                                <button type="button" wire:click="removeImage({{ $image['id'] }})"
                                    class="absolute top-0 right-0 bg-red-500 text-white text-md px-2 rounded-full group-hover:block hidden hover:cursor-pointer">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>