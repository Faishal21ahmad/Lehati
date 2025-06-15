<div class="px-6 pt-2 md:p-8 md:ml-64 text-black  dark:text-white">
    <x-layouts.app-header :title="__('Profile')" :description="__('Manage your profile settings and preferences.')" />

    <x-profile.layout :title="__('Profile')" :description="__('Update your profile information')">
        <form wire:submit="updateProfile" >
            <x-input.input type="text" id="name" name="name" label="Username" placeholder="Freya" required error="{{ $errors->first('name') }}"/>
            <x-input.input type="text" id="code_user" name="code_user" label="Code User" placeholder="XXXXXXXX" disabled error="{{ $errors->first('code_user') }}"/>
            <x-input.input type="email" id="email" name="email" label="Email" placeholder="halo@example.com" disabled error="{{ $errors->first('email') }}"/>
            <x-input.input type="role" id="role" name="role" label="Role" placeholder="admin" disabled error="{{ $errors->first('role') }}"/>
            
            <div class="flex items-center mt-4 gap-5">
                <x-button.btn type="submit" color="blue">Save</x-button.btn>
                <x-action-message class="me-3" on="profile-updated">{{ __('Saved.') }}</x-action-message>
            </div>
        </form>
    </x-profile.layout>
</div>