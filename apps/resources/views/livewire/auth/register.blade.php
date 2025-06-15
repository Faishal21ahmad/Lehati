<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <x-layouts.auth-header title="Lehati" description="Registrasi New Account" icon="genjie"/>

    <form wire:submit="register" class="w-full max-w-md px-4 mx-auto">
        <x-input.input type="text" id="name" name="name" label="Username" placeholder="Joko" required error="{{ $errors->first('name') }}"/>
        <x-input.input type="email" id="email" name="email" label="Email" placeholder="halo@example.com" required error="{{ $errors->first('email') }}"/>
        <x-input.input type="password" id="password" name="password" label="Password" placeholder="********" required error="{{ $errors->first('password') }}"/>
        <x-input.input type="password" id="passwordconfim" name="password_confirmation" label="Password Confirm" placeholder="********" required error="{{ $errors->first('password_confirmation') }}"/>
        
        <x-button.btn type="submit" class="w-full" color="blue">Submit</x-button.btn>
    </form>
    <div class="mt-10 text-sm text-center font-medium text-gray-500 dark:text-gray-300">Already have an account?
        <x-button.accorlink href="{{ route('login') }}" color="blue">Back to login</x-button.accorlink>
    </div>
</div>

