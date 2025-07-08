<x-layout>


@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-400/10 to-orange-600/10"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Chat & Kontak
                    <span class="bg-clip-text bg-gradient-to-r from-orange-500 to-orange-700">
                        Mechafix
                    </span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Hubungi tim Mechafix untuk konsultasi, pertanyaan, atau bantuan terkait
                    layanan perbaikan motor Anda.
                </p>

                <!-- Login Required Message -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 mb-12 max-w-2xl mx-auto shadow-xl border border-orange-200">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                        Login untuk Mengakses Chat
                    </h2>

                    <p class="text-gray-600 text-center mb-6">
                        Untuk mengakses fitur chat dengan mekanik dan tim support,
                        silakan login atau daftar akun terlebih dahulu.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-orange-500  font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
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

    <!-- Contact Methods Preview -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Cara Menghubungi Kami
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Berbagai cara untuk menghubungi tim Mechafix. Login untuk mengakses fitur chat langsung.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Chat Support -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-8 border border-orange-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Live Chat</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Chat langsung dengan tim support dan mekanik profesional untuk konsultasi
                        dan bantuan teknis.
                    </p>
                    <div class="bg-orange-100 rounded-lg p-3">
                        <p class="text-orange-800 text-sm font-medium text-center">Login untuk mengakses chat</p>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-8 border border-green-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">WhatsApp</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Hubungi kami melalui WhatsApp untuk konsultasi cepat dan bantuan
                        terkait layanan perbaikan motor.
                    </p>
                    <div class="bg-green-100 rounded-lg p-3">
                        <p class="text-green-800 text-sm font-medium text-center">+62 812-3456-7890</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 border border-blue-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Email</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Kirim email untuk pertanyaan detail, keluhan, atau kerjasama
                        dengan tim Mechafix.
                    </p>
                    <div class="bg-blue-100 rounded-lg p-3">
                        <p class="text-blue-800 text-sm font-medium text-center">support@mechafix.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Support Hours -->
    <div class="py-16 bg-gradient-to-br from-orange-50 to-orange-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Jam Operasional
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Tim support kami siap membantu Anda setiap hari.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Customer Support -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Customer Support</h3>
                        <div class="space-y-2 text-gray-600">
                            <p><strong>Senin - Jumat:</strong> 08:00 - 20:00 WIB</p>
                            <p><strong>Sabtu:</strong> 08:00 - 18:00 WIB</p>
                            <p><strong>Minggu:</strong> 09:00 - 17:00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Technical Support -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Technical Support</h3>
                        <div class="space-y-2 text-gray-600">
                            <p><strong>Senin - Jumat:</strong> 09:00 - 18:00 WIB</p>
                            <p><strong>Sabtu:</strong> 09:00 - 16:00 WIB</p>
                            <p><strong>Minggu:</strong> 10:00 - 15:00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Preview -->
    <div class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pertanyaan Umum
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Beberapa pertanyaan yang sering diajukan. Login untuk melihat FAQ lengkap.
                </p>
            </div>

            <div class="space-y-6">
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Bagaimana cara booking layanan?</h3>
                    <p class="text-gray-600 mb-4">
                        Login ke akun Anda, pilih layanan yang diinginkan, tentukan jadwal, dan lakukan pembayaran.
                    </p>
                    <div class="bg-orange-100 rounded-lg p-2">
                        <p class="text-orange-800 text-sm font-medium">Login untuk melihat panduan lengkap</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Apakah ada garansi untuk layanan?</h3>
                    <p class="text-gray-600 mb-4">
                        Ya, semua layanan kami dilengkapi dengan garansi sesuai dengan jenis layanan yang dipilih.
                    </p>
                    <div class="bg-orange-100 rounded-lg p-2">
                        <p class="text-orange-800 text-sm font-medium">Login untuk melihat detail garansi</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Bagaimana cara menghubungi mekanik?</h3>
                    <p class="text-gray-600 mb-4">
                        Setelah login, Anda dapat mengakses fitur chat untuk berkomunikasi langsung dengan mekanik.
                    </p>
                    <div class="bg-orange-100 rounded-lg p-2">
                        <p class="text-orange-800 text-sm font-medium">Login untuk mengakses chat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 bg-gradient-to-br from-orange-50 to-orange-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-orange-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Siap untuk Mulai Chat?
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Login sekarang dan nikmati layanan chat langsung dengan tim support dan mekanik profesional.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 font-semibold rounded-xl border-2 border-orange-500 hover:bg-orange-50 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
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
