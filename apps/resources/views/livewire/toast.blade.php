<div class="fixed top-4 right-4 z-50 space-y-3 w-full max-w-xs shadow-sm">
    @foreach($toasts as $toast)
        <div 
            x-data="{
                show: true,
                init() {
                    // Auto hide after duration
                    setTimeout(() => {
                        this.show = false;
                        this.$wire.remove('{{ $toast['id'] }}');
                    }, {{ $toast['duration'] }});
                }
            }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="flex items-center w-full p-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800"
            role="alert"
        >
            <!-- Icon Container -->
            <div @class([
                'inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg',
                'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200' => $toast['type'] === 'success',
                'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200' => $toast['type'] === 'error',
                'text-orange-500 bg-orange-100 dark:bg-orange-700 dark:text-orange-200' => $toast['type'] === 'info'
            ])>
                <!-- Icons -->
                @if($toast['type'] === 'success')
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                @elseif($toast['type'] === 'error')
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                @elseif($toast['type'] === 'info')
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                    </svg>
                @endif
                <span class="sr-only">{{ $toast['type'] }} icon</span>
            </div>
            <!-- Message -->
            <div class="ms-3 text-sm font-normal">{{ $toast['message'] }}</div>
            <!-- Close Button -->
            <button 
                @click="show = false; $wire.remove('{{ $toast['id'] }}')"
                type="button" 
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" 
                aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endforeach
</div>