<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MechaFix</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-50 to-white">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo dan Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-orange-500 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-tools text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">MechaFix</h2>
                <p class="mt-2 text-sm text-gray-600">Buat akun baru Anda</p>
            </div>

            <!-- Form Register -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100" x-data="{ showPassword: false, showConfirmPassword: false, passwordStrength: 0 }">
                <form method="POST" action="{{ route('customer.register') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user text-orange-500 mr-2"></i>Nama Lengkap
                        </label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            autocomplete="name" 
                            required 
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                            placeholder="Masukkan nama lengkap"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope text-orange-500 mr-2"></i>Email
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                            placeholder="Masukkan email Anda"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock text-orange-500 mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                name="password" 
                                :type="showPassword ? 'text' : 'password'" 
                                autocomplete="new-password" 
                                required
                                @input="passwordStrength = $event.target.value.length >= 8 ? ((/[A-Z]/.test($event.target.value) && /[a-z]/.test($event.target.value) && /[0-9]/.test($event.target.value)) ? 3 : 2) : 1"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                                placeholder="Masukkan password (min. 8 karakter)"
                            >
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-orange-500"
                            >
                                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                            </button>
                        </div>
                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="flex space-x-1">
                                <div class="flex-1 h-2 rounded-full" :class="passwordStrength >= 1 ? 'bg-red-400' : 'bg-gray-200'"></div>
                                <div class="flex-1 h-2 rounded-full" :class="passwordStrength >= 2 ? 'bg-yellow-400' : 'bg-gray-200'"></div>
                                <div class="flex-1 h-2 rounded-full" :class="passwordStrength >= 3 ? 'bg-green-400' : 'bg-gray-200'"></div>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">
                                Password harus minimal 8 karakter dengan huruf besar, kecil, dan angka
                            </p>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock text-orange-500 mr-2"></i>Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                :type="showConfirmPassword ? 'text' : 'password'" 
                                autocomplete="new-password" 
                                required
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                                placeholder="Konfirmasi password Anda"
                            >
                            <button 
                                type="button" 
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-orange-500"
                            >
                                <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-center">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            required
                            class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-300 rounded"
                        >
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            Saya menyetujui 
                            <a href="#" class="text-orange-500 hover:text-orange-600 font-medium">Syarat & Ketentuan</a> 
                            dan 
                            <a href="#" class="text-orange-500 hover:text-orange-600 font-medium">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <!-- Register Button -->
                    <button 
                        type="submit"
                        class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg hover:bg-orange-600 focus:ring-4 focus:ring-orange-200 transition-all duration-200 font-medium"
                    >
                        <i class="fas fa-user-plus mr-2"></i>Daftar
                    </button>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun? 
                            <a href="{{ route('customer.login') }}" class="text-orange-500 hover:text-orange-600 font-medium">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="text-center">
                <p class="text-xs text-gray-500">
                    Dengan mendaftar, Anda akan mendapatkan akses ke layanan bengkel terbaik
                </p>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('status'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('status') }}</span>
                <button @click="show = false" class="ml-4 text-green-700 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>Terjadi kesalahan, silakan periksa kembali.</span>
                <button @click="show = false" class="ml-4 text-red-700 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
</body>
</html>