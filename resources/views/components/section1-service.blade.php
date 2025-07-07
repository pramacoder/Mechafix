{{-- resources/views/components/services-section.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-purple-200 to-gray-100 py-16 px-4 mt-20" x-data="servicesComponent()">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-16 ">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Your Trusted Motorbike Repair Solutions
            </h1>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                We specialise in providing reliable proof of repair for your motorcycle. Our expert job estimation service ensures transparency and trust.
            </p>
            <div class="mt-8">
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-green-500 mx-auto rounded-full"></div>
            </div>
        </div>

        {{-- Services Grid --}}
        <div class="grid md:grid-cols-3 gap-8">
            {{-- Service 1: Comprehensive Job Estimation --}}
            <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-105">
                <div class="relative overflow-hidden rounded-2xl mb-6">
                    <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-blue-400 to-blue-600">
                        <div class="absolute inset-0 flex items-center justify-center">

                            <div class="w-full h-full bg-cover bg-center bg-gray-300 rounded-2xl flex items-center justify-center">
 <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>                               
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div>
                </div>
                
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Comprehensive Job Estimation for Every Repair
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        We have plenty of expert mechanics to get your bike healthy in no time.
                    </p>
                </div>
                
                <div class="mt-6 flex justify-center">
                    <div class="w-12 h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></div>
                </div>
            </div>

            {{-- Service 2: Quality Parts --}}
            <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-105">
                <div class="relative overflow-hidden rounded-2xl mb-6">
                    <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-green-400 to-green-600">
                        <div class="absolute inset-0 flex items-center justify-center">
                            {{-- Placeholder for parts image --}}
                            <div class="w-full h-full bg-cover bg-center bg-gray-300 rounded-2xl flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div>
                </div>
                
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Quality Parts for Your Motorbike Needs
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        We always provide the most wearable items with guaranteed quality and authenticity.
                    </p>
                </div>
                
                <div class="mt-6 flex justify-center">
                    <div class="w-12 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full"></div>
                </div>
            </div>

            {{-- Service 3: Reliable Proof of Repair --}}
            <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-105">
                <div class="relative overflow-hidden rounded-2xl mb-6">
                    <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-purple-400 to-purple-600">
                        <div class="absolute inset-0 flex items-center justify-center">
                            {{-- Placeholder for documentation image --}}
                            <div class="w-full h-full bg-cover bg-center bg-gray-300 rounded-2xl flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div>
                </div>
                
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Reliable Proof of Repair Documentation
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        We always provide proof of damaged goods with detailed documentation and transparency.
                    </p>
                </div>
                
                <div class="mt-6 flex justify-center">
                    <div class="w-12 h-1 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Call to Action Section --}}
        <div class="mt-16 bg-gradient-to-br from-purple-900 via-orange-500 to-orange-50 rounded-3xl p-8 md:p-12 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-white opacity-10"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Ready to Get Your Bike Fixed?
                </h2>
                <p class="text-xl mb-8 opacity-90">
                    Contact our expert mechanics today for a comprehensive repair estimate
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-white text-blue-600 font-semibold py-3 px-8 rounded-xl hover:bg-gray-100 transition-colors duration-200 transform hover:scale-105">
                        Book Service Now
                    </button>
                    <button class="border-2 border-white text-white font-semibold py-3 px-8 rounded-xl hover:bg-white hover:text-blue-600 transition-all duration-200 transform hover:scale-105">
                        Check Estimate
                    </button>
                </div>
            </div>
            
            {{-- Decorative elements --}}
            <div class="absolute -top-4 -right-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
        </div>

        {{-- Features Section --}}
        <div class="mt-16 grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-blue-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Fast Service</h3>
                <p class="text-gray-600 text-sm">Quick turnaround time for all repairs</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-green-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Fast Service</h3>
                <p class="text-gray-600 text-sm">Quick turnaround time for all repairs</p>
            </div>

            <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-yellow-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Trusted Quality</h3>
                <p class="text-gray-600 text-sm">Only certified parts and skilled labor</p>
            </div>

            <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-purple-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h2l1 2h13l1-2h2M6 6h12l-1.5 6h-9L6 6z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Verified Work</h3>
                <p class="text-gray-600 text-sm">Get official repair documentation</p>
            </div>

            <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-red-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Customer Satisfaction</h3>
                <p class="text-gray-600 text-sm">Excellent reviews and happy clients</p>
            </div>
        </div>
    </div>
</div>