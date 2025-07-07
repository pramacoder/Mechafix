{{-- resources/views/components/brand-carousel.blade.php --}}
<div class="relative overflow-hidden py-12" style="background: linear-gradient(90deg,rgb(148, 67, 0) 0%, #fdba74 100%);">
    <!-- Ornamen SVG Bulat & Wave -->
    <svg class="absolute top-0 left-0 w-48 h-48 opacity-20 -z-10" style="filter: blur(2px);" viewBox="0 0 200 200"><circle cx="100" cy="100" r="100" fill="#fff" /></svg>
    <svg class="absolute bottom-0 right-0 w-32 h-32 opacity-10 -z-10" style="filter: blur(1px);" viewBox="0 0 200 200"><circle cx="100" cy="100" r="100" fill="#fff" /></svg>
    <svg class="absolute top-1/2 left-0 w-full h-10 opacity-10 -z-10" viewBox="0 0 1440 60" fill="none"><path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#fff"/></svg>


    <!-- Infinite Scroll Container -->
    <div class="relative z-10" x-data="brandCarousel()">
        <div class="flex animate-scroll-left-elegant" style="will-change: transform;">
            <!-- First set of brands -->
            <div class="flex shrink-0 items-center justify-around min-w-full">
                <div class="flex items-center space-x-12 px-8">
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                </div>
            </div>
            <!-- Duplicate set for seamless loop -->
            <div class="flex shrink-0 items-center justify-around min-w-full">
                <div class="flex items-center space-x-12 px-8">
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('download.png') }}" alt="Yamaha" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border-4 border-white p-2 transition-transform duration-300 hover:scale-110 hover:shadow-2xl">
                        <img src="{{ asset('Honda_logo.svg') }}" alt="Honda" class="h-16 md:h-20 w-auto object-contain ">
                    </div>
                </div>
            </div>
        </div>
    </div>
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
@keyframes scroll-left-elegant {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%);
    }
}

.animate-scroll-left-elegant {
    animation: scroll-left-elegant 40s linear infinite;
}

.animate-scroll-left-elegant:hover {
    animation-play-state: paused;
}
</style>