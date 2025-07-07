<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-r from-orange-400/10 to-orange-600/10"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('LogoMechafix.svg') }}" alt="Mechafix Logo" 
                         class="w-24 h-24 object-contain bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl shadow-2xl">
                </div>
                
                <!-- Main Heading -->
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Selamat Datang di
                    <span class="bg-clip-text bg-gradient-to-r from-orange-500 to-orange-700 text-orange-500">
                        Mechafix
                    </span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Workshop terpercaya untuk perbaikan dan perawatan motor Anda. 
                    Dapatkan layanan berkualitas dari mekanik profesional.
                </p>
                
                <!-- Login Required Message -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 mb-12 max-w-2xl mx-auto shadow-xl border border-orange-200">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-orange-600 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                        Login Terlebih Dahulu
                    </h2>
                    
                    <p class="text-gray-600 text-center mb-6">
                        Untuk mengakses layanan lengkap Mechafix, silakan login atau daftar akun terlebih dahulu.
                    </p>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-orange-600 border-2 border-orange-500 font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login
                        </a>
                        
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 font-semibold rounded-xl border-2 border-orange-500 hover:bg-orange-50 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Mengapa Memilih Mechafix?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Platform terdepan yang menghubungkan Anda dengan mekanik profesional 
                    untuk perawatan motor yang terpercaya dan berkualitas.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-600 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Mekanik Terverifikasi</h3>
                    <p class="text-gray-600">
                        Semua mekanik telah melalui proses verifikasi dan memiliki sertifikasi profesional.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-600 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Layanan 24/7</h3>
                    <p class="text-gray-600">
                        Booking layanan kapan saja, di mana saja. Layanan tersedia 24 jam sehari.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-600 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Harga Transparan</h3>
                    <p class="text-gray-600">
                        Tidak ada biaya tersembunyi. Semua harga sudah jelas dan transparan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Preview -->
    <div class="py-16 bg-gradient-to-br from-orange-50 to-orange-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Layanan Unggulan Kami
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Berbagai layanan perbaikan dan perawatan motor yang dapat Anda akses setelah login.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Service 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Tune Up</h3>
                    <p class="text-gray-600 text-sm">Perawatan berkala untuk performa optimal motor</p>
                </div>
                
                <!-- Service 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Ganti Oli</h3>
                    <p class="text-gray-600 text-sm">Penggantian oli mesin untuk perawatan rutin</p>
                </div>
                
                <!-- Service 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Service Rem</h3>
                    <p class="text-gray-600 text-sm">Perbaikan dan perawatan sistem pengereman</p>
                </div>
                
                <!-- Service 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Spare Parts</h3>
                    <p class="text-gray-600 text-sm">Penggantian spare part berkualitas tinggi</p>
                </div>
            </div>
            
            <!-- CTA Section -->
            <div class="text-center mt-12">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 max-w-2xl mx-auto shadow-xl border border-orange-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Siap untuk Memulai?
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Login sekarang dan nikmati layanan perbaikan motor terbaik dari mekanik profesional.
                    </p>
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-orange-600 border-2 border-orange-500 font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Login Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
</x-layout>