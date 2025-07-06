<x-layout>


@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-400/10 to-orange-600/10"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Profil
                    <span class="bg-clip-text bg-gradient-to-r from-orange-500 text-orange-500 to-orange-700">
                        Mechafix
                    </span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Kenali lebih dekat tim Mechafix yang siap memberikan layanan terbaik 
                    untuk perbaikan dan perawatan motor Anda.
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
                        Login untuk Melihat Profil Lengkap
                    </h2>
                    
                    <p class="text-gray-600 text-center mb-6">
                        Untuk melihat detail profil tim dan informasi lengkap tentang Mechafix, 
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

    <!-- Company Overview -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Tentang Mechafix
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Platform terdepan yang menghubungkan pemilik motor dengan mekanik profesional 
                    untuk layanan perbaikan dan perawatan yang terpercaya.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">
                        Visi Kami
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Menjadi platform terpercaya yang memudahkan pemilik motor mendapatkan 
                        layanan perbaikan berkualitas dari mekanik profesional yang terverifikasi.
                    </p>
                    
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">
                        Misi Kami
                    </h3>
                    <ul class="text-gray-600 space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Menyediakan platform yang mudah digunakan untuk booking layanan motor
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Memastikan kualitas layanan dari mekanik yang terverifikasi
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Memberikan transparansi harga dan layanan
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Meningkatkan kepuasan pelanggan melalui layanan berkualitas
                        </li>
                    </ul>
                </div>
                
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-8 border border-orange-200">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Tim Profesional</h3>
                        <p class="text-gray-600 mb-4">
                            Login untuk melihat profil lengkap tim mekanik profesional kami 
                            yang siap memberikan layanan terbaik.
                        </p>
                        <div class="bg-orange-100 rounded-lg p-3">
                            <p class="text-orange-800 text-sm font-medium">Login untuk melihat detail tim</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="py-16 bg-gradient-to-br from-orange-50 to-orange-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Nilai-Nilai Kami
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Prinsip-prinsip yang menjadi dasar layanan Mechafix untuk kepuasan pelanggan.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Kualitas</h3>
                    <p class="text-gray-600 text-center">
                        Memastikan setiap layanan yang diberikan memenuhi standar kualitas tertinggi 
                        dengan menggunakan spare parts berkualitas dan mekanik terverifikasi.
                    </p>
                </div>
                
                <!-- Value 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Kecepatan</h3>
                    <p class="text-gray-600 text-center">
                        Memberikan layanan yang cepat dan efisien tanpa mengorbankan kualitas, 
                        sehingga motor Anda siap digunakan kembali dalam waktu singkat.
                    </p>
                </div>
                
                <!-- Value 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-500 border-2 border-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Transparansi</h3>
                    <p class="text-gray-600 text-center">
                        Memberikan informasi yang jelas dan transparan mengenai harga, 
                        layanan, dan proses perbaikan yang akan dilakukan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-8 border border-orange-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Bergabung dengan Mechafix
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Login sekarang dan nikmati layanan perbaikan motor terbaik dari tim profesional kami.
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