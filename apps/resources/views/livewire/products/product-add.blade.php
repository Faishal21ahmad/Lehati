<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Add Product')" :description="__('Create New Your Product ')" />

    <div class="lg:w-1/2">
        <form wire:submit="createProduct">
            <x-input.input type="text" id="name_product" name="name_product" label="Name Product" placeholder="Cabe" required error="{{ $errors->first('name_product') }}"/>
                
            <div class="flex gap-4 w-full">
                <x-input.input type="number" id="quantity" name="quantity" label="Quantity" placeholder="1" required error="{{ $errors->first('quantity') }}"/>
                <x-input.select 
                    name="units" 
                    id="units" 
                    label="Unit" 
                    placeholder="Pilih unit" 
                    :options="[
                        ['value' => 'kg', 'label' => 'Kg'],
                        ['value' => 'ton', 'label' => 'Ton'],
                        ['value' => 'ons', 'label' => 'Ons'],
                        ['value' => 'ikat', 'label' => 'Ikat']
                    ]" 

                    error="{{ $errors->first('units') }}"
                />
                
            </div>
            <x-input.textarea 
                name="description" 
                id="description" 
                label="Description" 
                placeholder=""
                error="{{ $errors->first('description') }}"
            />
            
            <x-input.file 
                id="fileproduct"
                name="fileproduct" 
                label="Profile Picture" 
                accept="image/*"
                :multiple="true"
                :required="true"
                helpText="Upload your profile photo (jpeg, png, jpg)"
                error="{{ $errors->first('fileproduct.*') }}"
            />
            {{-- @error('fileproduct.*') <span class="error">{{ $message }}</span> @enderror --}}
            <x-button.btn type="submit" class="">Submit</x-button.btn>
            <x-button.btnaccorlink type="button" href="{{ Route('products') }}" color="yellow">Cencel</x-button.btnaccorlink>
        </form>
    </div>

                
</div>