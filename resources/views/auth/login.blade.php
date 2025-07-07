<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-100 via-white to-orange-50">
        <div class="w-full max-w-md border-2 border-orange-500 bg-white shadow-xl p-10" style="border-radius:0;">
            <div class="mb-8 text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('LogoMechafix.svg') }}" alt="">
            </div>
                <h1 class="text-3xl font-bold text-orange-600 mt-4 mb-2 tracking-tight">Login to Mechafix</h1>
                <p class="text-gray-700">Masuk untuk mengakses layanan terbaik kami</p>
            </div>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-black mb-1">Email</label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="username" placeholder="Masukkan email anda" value="{{ old('email') }}" class="block w-full px-4 py-3 border-b-2 border-orange-500 bg-transparent text-black placeholder-gray-400 focus:outline-none focus:border-orange-600 transition" style="border-radius:0;" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-black mb-1">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Masukkan password" class="block w-full px-4 py-3 border-b-2 border-orange-500 bg-transparent text-black placeholder-gray-400 focus:outline-none focus:border-orange-600 transition" style="border-radius:0;" />
                </div>

                <div class="flex items-center justify-between mt-2">
                    <label for="remember_me" class="flex items-center select-none">
                        <input id="remember_me" name="remember" type="checkbox" class="accent-orange-600 mr-2" />
                        <span class="text-sm text-gray-700">Remember me</span>
                    </label>
                    <div>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-orange-600 hover:text-orange-500 font-semibold transition" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col gap-3 mt-8">
                    <button type="submit" class="w-full py-2 bg-orange-600 text-white font-semibold text-sm tracking-widest hover:bg-orange-500 transition rounded-md">
                        Log in
                    </button>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-full py-2 text-center border-2 border-orange-500 text-orange-600 font-semibold text-sm tracking-widest hover:bg-orange-50 transition rounded-md">
                            Daftar Akun Baru
                        </a>
                    @endif
                    <a href="{{ route('guest.home') }}" class="w-full py-2 text-center border-2 border-black text-black font-semibold text-sm tracking-widest hover:bg-gray-100 transition rounded-md">
                        Masuk Sebagai Guest
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
