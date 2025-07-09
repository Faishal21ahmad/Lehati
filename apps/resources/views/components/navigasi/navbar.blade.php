<nav class="bg-white dark:bg-gray-800 fixed w-full z-40 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
    <div class="max-w-screen-2xl flex flex-wrap items-center justify-between mx-auto p-4">
        <x-button.logoapp href="{{ route('home') }}" icon="genjie" title="Lehati" />
        
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse gap-2">
        @if (Route::has('login'))
            @auth
                <x-button.btnaccorlink href="{{ route('dashboard') }}" color="blue" class="">Dashboard</x-button.btnaccorlink>
            @else
                <x-button.btnaccorlink href="{{ route('login') }}" color="blue" class="">Login</x-button.btnaccorlink>
                @if (Route::has('register'))
                    <x-button.btnaccorlink href="{{ route('register') }}" color="blue" class="">Register</x-button.btnaccorlink>
                @endif
            @endauth
        @endif
        </div>
        
    </div>
</nav>