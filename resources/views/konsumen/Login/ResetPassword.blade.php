<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - MechaFix</title>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-50 to-white">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo dan Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-orange-500 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-key text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
                <p class="mt-2 text-sm text-gray-600">Masukkan email untuk reset password</p>
            </div>

            <!-- Form Reset Password -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100" x-data="{ isSubmitted: false }">
                <form method="POST" action="{{ route('customer.password.email') }}" class="space-y-6" @submit="isSubmitted = true">
                    @csrf
                    
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
                            placeholder="Masukkan email yang terdaftar"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Information Box -->
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-orange-500 mt-1 mr-3"></i>
                            <div class="text-sm text-orange-800">
                                <p class="font-medium">Instruksi Reset Password:</p>
                                <ul class="list-disc list-inside mt-1 space-y-1">
                                    <li>Masukkan email yang terdaftar di akun Anda</li>
                                    <li>Kami akan mengirim link reset password ke email</li>
                                    <li>Klik link di email untuk membuat password baru</li>
                                    <li>Link berlaku selama 60 menit</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        :disabled="isSubmitted"
                        class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg hover:bg-orange-600 focus:ring-4 focus:ring-orange-200 transition-all duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span x-show="!isSubmitted">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Link Reset Password
                        </span>
                        <span x-show="isSubmitted">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...
                        </span>
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Ingat password Anda? 
                            <a href="{{ route('customer.login') }}" class="text-orange-500 hover:text-orange-600 font-medium">
                                Kembali ke login
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Additional Help -->
            <div class="text-center">
                <p class="text-xs text-gray-500">
                    Butuh bantuan? Hubungi customer service kami di 
                    <a href="tel:+6281234567890" class="text-orange-500 hover:text-orange-600 font-medium">
                        +62 812-3456-7890
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('status'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg max-w-md" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-start">
                <i class="fas fa-check-circle mr-2 mt-1"></i>
                <div class="flex-1">
                    <p class="font-medium">Email berhasil dikirim!</p>
                    <p class="text-sm">{{ session('status') }}</p>
                </div>
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