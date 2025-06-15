<x-layouts.base :title="$title">
    <div class="flex flex-col min-h-screen">
        @include('components.navigasi.navbar') 
        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</x-layouts.base>