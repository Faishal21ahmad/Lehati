<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Profile')" :description="__('Manage your profile settings and preferences.')" />

    <x-profile.layout :title="__('Password')" :description="__('Update your profile information')">
        <form wire:submit="updatePassword" >
            <x-input.input type="password" id="current_password" name="current_password" label="Current Password" placeholder="********" required error="{{ $errors->first('current_password') }}"/>
            <x-input.input type="password" id="password" name="password" label="Password" placeholder="********" required error="{{ $errors->first('password') }}"/>
            <x-input.input type="password" id="password_confirmation" name="password_confirmation" label="Password Confirmation" placeholder="********" required error="{{ $errors->first('password_confirmation') }}"/>
            
            <div class="flex items-center mt-4 gap-5">
                <x-button.btn type="submit" color="blue">Save</x-button.btn>
                <x-action-message class="me-3" on="password-updated">{{ __('Saved.') }}</x-action-message>
            </div>
        </form>
        
    </x-profile.layout>
</div>
