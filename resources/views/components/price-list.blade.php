{{-- resources/views/components/pricing-section.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-orange-500 to-gray-100 py-16 px-border-b-5 border-black" x-data="pricingComponent()">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 text-orange-600 font-medium text-sm mb-4">
                MECHAFIX
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Pricelist
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Compare our member pricing and save on services!
            </p>
        </div>

        {{-- Quick Price Cards --}}
        <div class="grid md:grid-cols-2 gap-8 mb-16">
            {{-- Basic Service Card --}}
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Basic</h3>
                        <p class="text-gray-600">start from :</p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-gray-900">Rp. 45.000</span>
                    </div>
                    <p class="text-gray-600 mt-1">for service</p>
                </div>
                
                <p class="text-gray-600 mb-6">Ideal for casual riders</p>
                
                <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                    Get started
                </button>
            </div>

            {{-- Parts Card --}}
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Parts</h3>
                        <p class="text-gray-600">Start from :</p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-gray-900">Rp. 15.000</span>
                    </div>
                    <p class="text-gray-600 mt-1">Per Parts</p>
                </div>
                
                <p class="text-gray-600 mb-6">Best price fort the best part</p>
                
                <a href="{{ route('konsumen.part_shop') }}" class="w-full block text-center bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                    See Product
                </a>
            </div>
        </div>

        {{-- Features Table --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-16">
            <div class="px-8 py-6 bg-gray-50 border-b">
                <h3 class="text-xl font-bold text-gray-900">Feature Category</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-orange-50">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">CC Category</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">110 - 125 cc</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">150 - 250 cc</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">> 250cc</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">Service Discounts</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">10</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">15</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">25</td>
                        </tr>
                        <tr class="hover:bg-gray-50 bg-gray-25">
                            <td class="px-6 py-4 text-sm text-gray-900">Priority Support</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-gray-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">Free Maintenance Check</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pricing Cards --}}
        <div class="grid md:grid-cols-3 gap-8">
            {{-- 110-125cc Card --}}
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">110 - 125 cc</h3>
                    <div class="flex items-baseline justify-center mb-4">
                        <span class="text-2xl font-bold text-gray-900">Rp</span>
                        <span class="text-4xl font-bold text-gray-900">45.000</span>
                        <span class="text-gray-600 ml-2">/bike</span>
                    </div>
                </div>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Basic Service
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        10% Discount
                    </li>
                </ul>
                
                <a href="/konsumen/services#booking-section" class="w-full block text-center bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                    Booking Service
                </a>
            </div>

            {{-- 150-250cc Card (Popular) --}}
            <div class="bg-black to-orange-600 rounded-2xl p-8 shadow-2xl border-4 border-orange-400 hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-3 hover:scale-105 relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-full text-sm font-bold">Most Popular</span>
                </div>
                
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-white mb-2">150 - 250 cc</h3>
                    <div class="flex items-baseline justify-center mb-4">
                        <span class="text-2xl font-bold text-white">Rp</span>
                        <span class="text-4xl font-bold text-white">50.000</span>
                        <span class="text-orange-200 ml-2">/bike</span>
                    </div>
                </div>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-white">
                        <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Basic Service
                    </li>
                    <li class="flex items-center text-white">
                        <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Priority Support
                    </li>
                    <li class="flex items-center text-white">
                        <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Exclusive Offers
                    </li>
                    <li class="flex items-center text-white">
                        <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        15% Discount
                    </li>
                </ul>
                
                <a href="/konsumen/services#booking-section" class="w-full block text-center bg-white hover:bg-gray-100 text-orange-600 font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                    Booking Service
                </a>
            </div>

            {{-- >250cc Card --}}
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">> 250cc</h3>
                    <div class="flex items-baseline justify-center mb-4">
                        <span class="text-2xl font-bold text-gray-900">Rp</span>
                        <span class="text-4xl font-bold text-gray-900">70.000</span>
                        <span class="text-gray-600 ml-2">/bike</span>
                    </div>
                </div>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Special Service
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Priority Support
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Exclusive Offers
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        25% Discount
                    </li>
                </ul>
                
                <a href="/konsumen/services#booking-section" class="w-full block text-center bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                    Booking Service
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function pricingComponent() {
    return {
        selectedPlan: '150-250cc',
        init() {
            // Animation on scroll
            this.observeElements();
        },
        observeElements() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.pricing-card').forEach(card => {
                observer.observe(card);
            });
        }
    }
}

// Smooth scroll untuk Booking Service ke #booking-section
const bookingLinks = document.querySelectorAll('a[href="/konsumen/services#booking-section"]');
bookingLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        // Cek jika di halaman yang sama
        if (window.location.pathname === '/konsumen/services') {
            e.preventDefault();
            const target = document.getElementById('booking-section');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
});
</script>

<style>
@keyframes fade-in-up {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out;
}
</style>