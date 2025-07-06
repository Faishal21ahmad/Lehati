@props([
    'fileproduct' => [],
    'wight' => 'w-full h-56 md:h-96',
])

@php

@endphp

<div 
    x-data="carousel()"
    x-init="init()"
    @mouseenter="pause()"
    @mouseleave="play()"
    id="default-carousel" 
    class="relative "
    wire:ignore
>
    <!-- Carousel wrapper -->
    <div class="{{ $wight }} relative overflow-hidden rounded-lg 
    ">
        <template x-for="(image, index) in images" :key="index">
            <div 
                x-show="activeIndex === index"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-700"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="-translate-x-full opacity-0"
                class="absolute inset-0 duration-700 ease-in-out"
                data-carousel-item
            >
                <img 
                    :src="'/storage/' + image.image_path" 
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" 
                    :alt="'Product image ' + (index + 1)"
                >
            </div>
        </template>
    </div>
    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
        <template x-for="(image, index) in images" :key="'indicator-'+index">
            <button 
                type="button" 
                @click="goTo(index)"
                class="w-3 h-3 rounded-full"
                :class="{ 'bg-white': activeIndex === index, 'bg-white/50': activeIndex !== index }"
                :aria-current="activeIndex === index ? 'true' : 'false'"
                :aria-label="'Slide ' + (index + 1)"
                data-carousel-slide-to="index"
            ></button>
        </template>
    </div>

    <!-- Slider controls -->
    <button 
        type="button" 
        @click="prev()"
        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-prev
    >
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button 
        type="button" 
        @click="next()"
        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-next
    >
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('carousel', () => ({
        activeIndex: 0,
        interval: 5000, // 5 detik
        intervalId: null,
        isTransitioning: false,
        images: @json($fileproduct),
        
        init() {
            this.startAutoPlay();
            
            if (window.Livewire) {
                Livewire.on('carouselUpdated', () => {
                    this.images = @json($fileproduct);
                    this.activeIndex = 0;
                    this.restartAutoPlay();
                });
            }
        },
        
        startAutoPlay() {
            this.intervalId = setInterval(() => {
                if (!this.isTransitioning) {
                    this.next();
                }
            }, this.interval);
        },
        
        pause() {
            if (this.intervalId) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }
        },
        
        play() {
            if (!this.intervalId) {
                this.startAutoPlay();
            }
        },
        
        restartAutoPlay() {
            this.pause();
            this.play();
        },
        
        next() {
            if (this.isTransitioning || this.images.length === 0) return;
            
            this.isTransitioning = true;
            
            // Jika sudah di slide terakhir, kembali ke slide pertama
            if (this.activeIndex === this.images.length - 1) {
                setTimeout(() => {
                    this.activeIndex = 0;
                    this.isTransitioning = false;
                }, 700);
            } else {
                this.activeIndex++;
                setTimeout(() => {
                    this.isTransitioning = false;
                }, 700);
            }
        },
        
        prev() {
            if (this.isTransitioning || this.images.length === 0) return;
            
            this.isTransitioning = true;
            
            // Jika sudah di slide pertama, kembali ke slide terakhir
            if (this.activeIndex === 0) {
                setTimeout(() => {
                    this.activeIndex = this.images.length - 1;
                    this.isTransitioning = false;
                }, 700);
            } else {
                this.activeIndex--;
                setTimeout(() => {
                    this.isTransitioning = false;
                }, 700);
            }
        },
        
        goTo(index) {
            if (this.isTransitioning || this.images.length === 0) return;
            
            this.isTransitioning = true;
            this.activeIndex = index;
            
            setTimeout(() => {
                this.isTransitioning = false;
                this.restartAutoPlay();
            }, 700);
        }
    }));
});
</script>