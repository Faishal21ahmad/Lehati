<x-layouts.auth.wrapper :title="__('Forgot Password')">
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <x-layouts.auth.header title="Lehati" description="Confirm Your Email" icon="genjie"/>
        <form class="w-full max-w-md px-4 mx-auto">
            <x-input.input type="email" id="email" name="email" label="Email" placeholder="halo@example.com" required class="" />
            <x-button.btn type="submit" class="w-full" color="blue">Submit</x-button.btn>
        </form>
        <div class="mt-10 text-sm text-center font-medium text-gray-500 dark:text-gray-300">I think I remember my password? 
            <x-button.accorlink href="{{ route('login') }}" color="blue"> Back to login</x-button.accorlink>
        </div>
    </div>
</x-layouts.auth.wrapper>