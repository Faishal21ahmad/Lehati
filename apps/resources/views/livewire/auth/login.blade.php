
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <x-layouts.auth-header title="Lehati" description="Please enter your credentials to login." icon="genjie" />
        @if (session('status'))
            <div class="w-full max-w-md px-4 mb-4">
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                    {{ session('status') }}
                </div>
            </div>
        @endif
        <form wire:submit="login" class="w-full max-w-md px-4 mx-auto">
            <x-input.input type="email" id="email" name="email" label="Email" placeholder="halo@example.com" required error="{{ $errors->first('email') }}"/>
            <x-input.input type="password" id="password" name="password" placeholder="*********" label="Password" required error="{{ $errors->first('password') }}"/>
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <input wire:model="remember" id="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800">
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                </div>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                    <x-button.accorlink href="{{ route('forgot-password') }}" color="blue">Forgot password?</x-button.accorlink>
                </div>
            </div>
            <x-button.btn type="submit" class="w-full" color="blue">Login</x-button.btn>
        </form>
        <div class="mt-5 text-sm text-center font-medium text-gray-500 dark:text-gray-300">Not registered?<x-button.accorlink href="{{ route('register') }}" color="blue">Create account</x-button.accorlink></div>
    </div>
