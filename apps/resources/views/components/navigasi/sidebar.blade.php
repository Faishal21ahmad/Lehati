<div class="flex" x-data="{ sidebarOpen: window.innerWidth >= 768, isMobile() { return window.innerWidth < 768; } }" @resize.window="sidebarOpen = window.innerWidth >= 768">

    <button type="button" @click="sidebarOpen = !sidebarOpen" class="md:hidden inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>    
    <div class="md:hidden inline-flex items-center p-2 mt-2 ">
        <x-button.logoapp href="{{ route('home') }}" icon="genjie" title="Lehati" size="small" />
    </div>

    <!-- Mobile Overlay (only shows on mobile when sidebar is open) -->
    <div x-show="sidebarOpen && isMobile()" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-30 bg-gray-900/50"></div>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen || !isMobile()" 
        @keydown.escape="sidebarOpen = isMobile() ? false : true"
        x-transition:enter="transition ease-in-out duration-300"
        x-transition:enter-start="opacity-0 -translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-full"
        class="fixed top-0 left-0 z-40 w-64 h-screen bg-gray-100 dark:bg-gray-800">

        <div class="flex items-center justify-center h-16 px-4 mt-4">
            <x-button.logoapp href="{{ route('home') }}" icon="genjie" title="Lehati" size="large" />
        </div>
        <div class="h-full px-3 py-4 overflow-y-auto ">
            <ul class="space-y-2 font-medium">
                <x-navigasi.navlink href="{{ route('dashboard') }}" :icon="'diagram'" :active="request()->routeIs('dashboard')">Dashboard</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('products') }}" :icon="'products'" :active="request()->routeIs('products')">Product</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('room') }}" :icon="'room'" :active="request()->routeIs('room')">Room</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('transaction') }}" :icon="'transaction'" :active="request()->routeIs('transaction')">Transactions</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('account') }}" :icon="'users'" :active="request()->routeIs('account')">Account</x-navigasi.navlink>
                
                <x-navigasi.navgroup title="Products" :icon="'troli'" :iconrow="'arrowdown'">
                    <x-navigasi.navlink href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Dashboard</x-navigasi.navlink>
                    <x-navigasi.navlink href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Dashboard</x-navigasi.navlink>
                </x-navigasi.navgroup>
                <x-navigasi.navlink href="{{ route('profile') }}" :icon="'profile'" :active="request()->routeIs('profile')">Profile</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('userup') }}" :icon="'userup'" :active="request()->routeIs('userup')">Upgrade to Auctioner</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('logout') }}" :icon="'userlogout'" :active="request()->routeIs('logout')">Logout</x-navigasi.navlink>
                <div class="border-1 border-gray-300 dark:border-gray-600 rounded-full"></div>
            </ul>
        </div>
    </aside>
</div>