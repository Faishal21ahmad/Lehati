<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Profile')" :description="__('Manage your profile')" />

    <x-profile.layout :title="__('User Data')" :description="__('Update your data information')">
        <form wire:submit="updateUserData" >
            <x-input.input id="phone"  label="Phone" placeholder="08xx" required error="{{ $errors->first('phone') }}"/>
            <x-input.input id="address"  label="Address" placeholder="jl-kelurahan-kabupaten-provinsi" required error="{{ $errors->first('address') }}"/>
            <x-input.input id="nik"  label="NIK" placeholder="xxxx-xx-xxxx-xx" required error="{{ $errors->first('nik') }}"/>
            <x-input.radio-group title="Gender" name="gender"
                :options="[
                    ['value' => 'female', 'label' => 'Female'],
                    ['value' => 'male', 'label' => 'Male']
                ]"
                wire:model="gender"
                error="{{ $errors->first('gender') }}"
            />
            <x-input.input id="bank" label="Bank" placeholder="BRI" required error="{{ $errors->first('bank') }}"/>
            <x-input.input id="bank_name" label="Username Bank" placeholder="Freya" required error="{{ $errors->first('bank_name') }}"/>
            <x-input.input id="bank_number" label="Account Number" placeholder="08xx" required error="{{ $errors->first('bank_number') }}"/>

            <div class="flex items-center mt-4 gap-5">
                <x-button.btn type="submit" color="blue">Save</x-button.btn>
                <x-action-message class="me-3" on="data-updated">{{ __('Saved.') }}</x-action-message>
            </div>
        </form>
        
    </x-profile.layout>
</div>
