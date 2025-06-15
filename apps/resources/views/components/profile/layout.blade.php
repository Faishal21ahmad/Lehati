@props([
    'title' => 'Your Page Title',
    'description' => 'Your page description goes here.',
])

<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[160px] pt-2">
        <x-navigasi.navlink class="text-sm" href="{{ route('profile') }}">Profile</x-navigasi.navlink>
        <x-navigasi.navlink class="text-sm" href="{{ route('profile.data') }}">User Data</x-navigasi.navlink>
        <x-navigasi.navlink class="text-sm" href="{{ route('profile.password') }}">Password</x-navigasi.navlink>
    </div>
    <div class="w-full md:hidden">
        <div class="border-1 border-gray-300 dark:border-gray-600 rounded-full"></div>
    </div>
    <div class="flex-1 self-stretch max-md:pt-6 pt-5">
        
        <x-profile.header :title="__($title)" :description="__($description)"/>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
