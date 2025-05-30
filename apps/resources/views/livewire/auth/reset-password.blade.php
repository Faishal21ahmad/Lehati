<x-layouts.auth.wrapper :title="__('Register')">
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <x-layouts.auth.header title="Lehati" description="Enter New Password" icon="genjie"/>
        <form class="w-full max-w-md px-4 mx-auto">
            <x-input.input type="password" id="password" name="password" label="Password" placeholder="********" required class="" />
            <x-input.input type="password" id="passwordconfim" name="passwordconfim" label="Password Confirm" placeholder="********" required class="" />
            <x-button.btn type="submit" class="w-full" color="blue">Submit</x-button.btn>
        </form>
    </div>
</x-layouts.auth.wrapper>
