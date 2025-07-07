<x-layout>
    
@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-400/10 to-orange-600/10"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Toko Spare Parts
                    <span class=" bg-clip-text bg-gradient-to-r from-orange-500 to-orange-700 text-orange-500">
                        Mechafix
                    </span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Temukan spare parts berkualitas tinggi untuk motor Anda. 
                    Berbagai komponen original dan berkualitas dengan harga terbaik.
                </p>
                
                <!-- Login Required Message -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 mb-12 max-w-2xl mx-auto shadow-xl border border-orange-200">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                        Login untuk Membeli Spare Parts
                    </h2>
                    
                    <p class="text-gray-600 text-center mb-6">
                        Untuk melihat katalog lengkap dan melakukan pembelian spare parts, 
                        silakan login atau daftar akun terlebih dahulu.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-orange-500 border-2 border-orange-500 font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
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

    <!-- Parts Preview -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Spare Parts Unggulan
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Preview spare parts berkualitas tinggi yang tersedia. Login untuk melihat katalog lengkap dan harga.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Part 1 -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Kampas Rem</h3>
                    <p class="text-gray-600 text-sm text-center mb-4">
                        Kampas rem berkualitas tinggi untuk keamanan berkendara
                    </p>
                    <div class="bg-orange-100 rounded-lg p-2">
                        <p class="text-orange-800 text-xs font-medium text-center">Login untuk melihat harga</p>
                    </div>
                </div>
                
                <!-- Part 2 -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Oli Mesin</h3>
                    <p class="text-gray-600 text-sm text-center mb-4">
                        Oli mesin premium untuk performa optimal motor
                    </p>
                    <div class="bg-orange-100 rounded-lg p-2">
                        <p class="text-orange-800 text-xs font-medium text-center">Login untuk melihat harga</p>
                    </div>
                </div>
                
                <!-- Part 3 -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Filter Udara</h3>
                    <p class="text-gray-600 text-sm text-center mb-4">
                        Filter udara untuk menjaga kebersihan mesin
                    </p>
                    <div class="bg-orange-100 rounded-lg p-2">
                        <p class="text-orange-800 text-xs font-medium text-center">Login untuk melihat harga</p>
                    </div>
                </div>
                
                <!-- Part 4 -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Busi</h3>
                    <p class="text-gray-600 text-sm text-center mb-4">
                        Busi berkualitas untuk pembakaran yang sempurna
                    </p>
                    <div class="bg-orange-100 rounded-lg p-2">
                        <p class="text-orange-800 text-xs font-medium text-center">Login untuk melihat harga</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Preview -->
    <div class="py-16 bg-gradient-to-br from-orange-50 to-orange-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Kategori Spare Parts
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Berbagai kategori spare parts yang tersedia untuk berbagai jenis motor.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Category 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Mesin & Transmisi</h3>
                    <p class="text-gray-600 text-center mb-4">
                        Spare parts untuk mesin dan sistem transmisi motor
                    </p>
                    <div class="bg-orange-100 rounded-lg p-3">
                        <p class="text-orange-800 text-sm font-medium text-center">Login untuk melihat produk</p>
                    </div>
                </div>
                
                <!-- Category 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Sistem Pengereman</h3>
                    <p class="text-gray-600 text-center mb-4">
                        Komponen sistem pengereman untuk keamanan
                    </p>
                    <div class="bg-orange-100 rounded-lg p-3">
                        <p class="text-orange-800 text-sm font-medium text-center">Login untuk melihat produk</p>
                    </div>
                </div>
                
                <!-- Category 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Kelistrikan</h3>
                    <p class="text-gray-600 text-center mb-4">
                        Komponen sistem kelistrikan dan aksesoris
                    </p>
                    <div class="bg-orange-100 rounded-lg p-3">
                        <p class="text-orange-800 text-sm font-medium text-center">Login untuk melihat produk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-8 border border-orange-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Siap untuk Belanja Spare Parts?
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Login sekarang dan dapatkan spare parts berkualitas tinggi dengan harga terbaik.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-orange-500 border-2 border-orange-500 font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Login Sekarang
                    </a>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 font-semibold rounded-xl border-2 border-orange-500 hover:bg-orange-50 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Daftar Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

</x-layout>