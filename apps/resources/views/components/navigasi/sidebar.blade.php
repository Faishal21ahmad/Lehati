@php
$user = Auth::user();
    
@endphp


<div class="flex" 
    x-data="{
    sidebarOpen: window.innerWidth >= 768,
    isMobile() { return window.innerWidth < 768; }
    }"
    @resize.window="sidebarOpen = window.innerWidth >= 768">

    <!-- Tombol toggle (mobile only) -->
    <button type="button" 
            @click="sidebarOpen = !sidebarOpen" 
            class="md:hidden inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" />
        </svg>
    </button>

    <!-- Logo kecil di mobile -->
    <div class="md:hidden inline-flex items-center p-2 mt-2">
        <x-button.logoapp href="{{ route('home') }}" icon="genjie" title="Lehati" size="small" />
    </div>

    <!-- Overlay di mobile -->
    <div x-show="sidebarOpen && isMobile()" 
        @click="sidebarOpen = false" 
        x-transition.opacity 
        class="fixed inset-0 z-30 bg-gray-900/50">
    </div>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen || !isMobile()"
        @keydown.escape="sidebarOpen = isMobile() ? false : true"
        x-transition:enter="transition ease-in-out duration-300"
        x-transition:enter-start="opacity-0 -translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-full"
        class="fixed top-0 left-0 z-40 w-64 h-screen bg-gray-100 dark:bg-gray-800 flex flex-col">

        <!-- Logo Besar -->
        <div class="flex items-center justify-center h-16 px-4 mt-4 shrink-0">
            <x-button.logoapp href="{{ route('home') }}" icon="genjie" title="Lehati" size="large" />
        </div>

        <!-- Navigasi -->
        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-2 font-medium">
            @canany(["bidder","administrator"])
                <div class="border border-gray-300 dark:border-gray-600 rounded-full"></div>
                <span class="text-gray-400 text-sm py-5 px-2">Bidder</span>
                <x-navigasi.navlink href="{{ route('dashboard') }}" :icon="'diagram'" :active="request()->routeIs('dashboard')">Dashboard</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('room') }}" :icon="'room'" :active="request()->routeIs('room')">Room</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('transaction') }}" :icon="'transaction'" :active="request()->routeIs('transaction')">Transactions</x-navigasi.navlink>
            @endcanany

            @canany(["auctioneer","administrator"])
                <div class="border border-gray-300 dark:border-gray-600 rounded-full"></div>
                <span class="text-gray-400 text-sm py-5 px-2">Auctioneer</span>
                <x-navigasi.navlink href="{{ route('dashboard') }}" :icon="'diagram'" :active="request()->routeIs('dashboard')">Dashboard</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('products') }}" :icon="'products'" :active="request()->routeIs('products')">Product</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('room.manage') }}" :icon="'room'" :active="request()->routeIs('room.manage')">Manage Room</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('transaction') }}" :icon="'transaction'" :active="request()->routeIs('transaction')">Transactions</x-navigasi.navlink>
            @endcanany
            
            @canany(["admin","administrator"])
                <div class="border border-gray-300 dark:border-gray-600 rounded-full"></div>
                <span class="text-gray-400 text-sm py-5 px-2">Admin</span>
                <x-navigasi.navlink href="{{ route('dashboard') }}" :icon="'diagram'" :active="request()->routeIs('dashboard')">Dashboard</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('products') }}" :icon="'products'" :active="request()->routeIs('products')">Product</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('category') }}" :icon="'category'" :active="request()->routeIs('category')">Category</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('category') }}" :icon="'auctioneer'" :active="request()->routeIs('category')">Auctioneer</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('category') }}" :icon="'inboxrequest'" :active="request()->routeIs('category')">Inbox Request</x-navigasi.navlink>
                <x-navigasi.navlink href="{{ route('category') }}" :icon="'category'" :active="request()->routeIs('category')">Category</x-navigasi.navlink>
            @endcanany
            
            @canany(["administrator"])
                <x-navigasi.navlink href="{{ route('account') }}" :icon="'users'" :active="request()->routeIs('account')">Account</x-navigasi.navlink>
            @endcanany
            <div class="border border-gray-300 dark:border-gray-600 rounded-full"></div>
            <x-navigasi.navlink href="{{ route('profile') }}" :icon="'profile'" :active="request()->routeIs('profile','profile.data','profile.password')">Profile</x-navigasi.navlink>
            <x-navigasi.navlink href="{{ route('userup') }}" :icon="'userup'" :active="request()->routeIs('userup')">Upgrade to Auctioner</x-navigasi.navlink>
            <x-navigasi.navlink href="{{ url('logout') }}" :icon="'userlogout'" :active="request()->routeIs('logout')">Logout</x-navigasi.navlink>
        </div>

        <!-- Info User di bawah -->
        <div id="userinformasi" class="shrink-0 p-4 bg-gray-100 dark:bg-gray-800">
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-3">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-8 h-8 rounded-full bg-blue-500 dark:bg-blue-600 flex items-center justify-center text-white font-medium text-sm">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-700"></span>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        <div class="flex items-center">
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $user->role }}</span>
                            <span class="mx-1 text-gray-300 dark:text-gray-500">•</span>
                            <span class="text-xs text-blue-500 dark:text-blue-400">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>

{{-- <x-navigasi.navgroup title="Products" :icon="'troli'" :iconrow="'arrowdown'">
    <x-navigasi.navlink href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Dashboard</x-navigasi.navlink>
    <x-navigasi.navlink href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Dashboard</x-navigasi.navlink>
</x-navigasi.navgroup> --}}