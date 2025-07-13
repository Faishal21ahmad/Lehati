<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <x-layouts.auth-header title="Lehati" description="Enter New Password" icon="aloevera"/>
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">{{ session('status') }}</div>
    @endif
    @if (session('success'))
        <div class="mb-4 text-sm font-medium text-green-600">{{ session('success') }}</div>
    @endif
    <form wire:submit.prevent="resetPassword" class="w-full max-w-md px-4 mx-auto">
        <input type="hidden" wire:model="token">        
        <x-input.input type="email" id="email" name="email" label="Email" placeholder="halo@example.com" required wire:model="email" error="{{ $errors->first('email') }}" hidden/>
        <x-input.input type="password" id="password" name="password" label="Password" placeholder="********" required wire:model="password" error="{{ $errors->first('password') }}" />
        <x-input.input type="password" id="password_confirmation" name="password_confirmation" label="Password Confirm" placeholder="********" required wire:model="password_confirmation" error="{{ $errors->first('password_confirmation') }}" />
        <x-button.btn type="submit" class="w-full" color="blue">Reset Password</x-button.btn>
    </form>
</div>