<x-layouts.auth.wrapper :title="__('Login')">
    <!-- livewire/auth/login.blade.php -->
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <x-layouts.auth.header title="Lehati" description="Please enter your credentials to login." icon="genjie"/>
        <form wire:submit="login" class="w-full max-w-md px-4 mx-auto">
            <x-input.input wire:model="email" type="email" id="email" name="email" label="Email" placeholder="halo@example.com" required class="" />
            <x-input.input wire:model="password" type="password" id="password" name="password" placeholder="*********" label="Password" required class="" />
            <div class="mb-2 text-sm text-right font-medium text-gray-500 dark:text-gray-300">
                <x-button.accorlink href="{{ route('forgot-password') }}" color="blue">Forgot password?</x-button.accorlink>
            </div>
            <x-button.btn type="submit" class="w-full" color="blue">Login</x-button.btn>
        </form>
        <div class="mt-5 text-sm text-center font-medium text-gray-500 dark:text-gray-300">
            Not registered?<x-button.accorlink href="{{ route('register') }}" color="blue">Create account</x-button.accorlink>
        </div>
    </div>
</x-layouts.auth.wrapper>