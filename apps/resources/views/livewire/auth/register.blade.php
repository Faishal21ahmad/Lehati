<x-layouts.auth.wrapper :title="__('Register')">
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <x-layouts.auth.header title="Lehati" description="Registrasi New Account" icon="genjie"/>

        <form class="w-full max-w-md px-4 mx-auto">
            <x-input.input type="text" id="username" name="username" label="Username" placeholder="Joko" required class=""/>
            <x-input.input type="email" id="email" name="email" label="Email" placeholder="halo@example.com" required class="" />
            <x-input.input type="password" id="password" name="password" label="Password" placeholder="********" required class="" />
            <x-input.input type="password" id="passwordconfim" name="passwordconfim" label="Password Confirm" placeholder="********" required class="" />
            
            <x-button.btn type="submit" class="w-full" color="blue">Submit</x-button.btn>
            <div class="mt-10 text-sm text-center font-medium text-gray-500 dark:text-gray-300">Already have an account?
                <x-button.accorlink href="{{ route('login') }}" color="blue">Back to login</x-button.accorlink>
            </div>
        </form>
    </div>
</x-layouts.auth.wrapper>
