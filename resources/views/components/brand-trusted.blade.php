{{-- resources/views/components/brand-carousel.blade.php --}}
<div class="relative overflow-hidden bg-gradient-to-r from-orange-400 to-yellow-400 py-8 border-t-4 border-b-4" style="border-top-width:3px; border-bottom-width:3px; border-color:#000;">
    <div class="absolute inset-0 bg-orange opacity-10"></div>
    
    {{-- Header --}}
    <div class="relative z-10 text-center mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-black mb-2">
            Trusted by top brands in the industry
        </h2>
        <div class="w-full max-w-[400px] h-1 bg-black mx-auto rounded-full"></div>
    </div>

    {{-- Infinite Scroll Container --}}
    <div class="relative z-10" x-data="brandCarousel()">
        <div class="flex animate-scroll-left">
            {{-- First set of brands --}}
            <div class="flex shrink-0 items-center justify-around min-w-full">
                <div class="flex items-center space-x-8 px-8">
                    <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                </div>
            </div>
            
            {{-- Duplicate set for seamless loop --}}
            <div class="flex shrink-0 items-center justify-around min-w-full">
                <div class="flex items-center space-x-8 px-8">
                    <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                </div>
            </div>
        </div>
    </div>

    {{-- Decorative elements --}}
    <div class="absolute top-0 left-0 w-32 h-32 bg-white opacity-5 rounded-full -translate-x-16 -translate-y-16"></div>
    <div class="absolute bottom-0 right-0 w-24 h-24 bg-white opacity-5 rounded-full translate-x-12 translate-y-12"></div>
</div>

<script>
function brandCarousel() {
    return {
        init() {
            // Additional carousel logic if needed
        }
    }
}
</script>

<style>
@keyframes scroll-left {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%);
    }
}

.animate-scroll-left {
    animation: scroll-left 20s linear infinite;
}

.animate-scroll-left:hover {
    animation-play-state: paused;
}
</style>